<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Allowed Roles
    |--------------------------------------------------------------------------
    */

    private function allowedRoles($user): array
    {
        if ($user->hasRole('SuperAdmin')) {
            return [
                'Admin',
                'Member',
                'Sales',
                'Manager',
            ];
        }

        if ($user->hasRole('Admin')) {
            return [
                'Sales',
                'Manager',
            ];
        }

        return [];
    }


    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SuperAdmin
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('SuperAdmin')) {

            $invitations = Invitation::with('company')
                ->latest()
                ->paginate(10);
        }

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */ elseif ($user->hasRole('Admin')) {

            if (!$user->company_id) {
                abort(
                    403,
                    'Admin is not assigned to any company.'
                );
            }

            $invitations = Invitation::with('company')
                ->where('company_id', $user->company_id)
                ->latest()
                ->paginate(10);
        }

        /*
        |--------------------------------------------------------------------------
        | Other Roles
        |--------------------------------------------------------------------------
        */ else {

            abort(
                403,
                'You are not authorized to view invitations.'
            );
        }

        return view(
            'invitations.index',
            compact('invitations')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['SuperAdmin', 'Admin'])) {
            abort(
                403,
                'You are not authorized to create invitations.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Companies
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('SuperAdmin')) {

            // SuperAdmin can select any company
            $companies = Company::orderBy('name')->get();
        } else {

            // Admin must have a company
            if (!$user->company_id) {
                abort(
                    403,
                    'Admin is not assigned to any company.'
                );
            }

            // Admin can only use own company
            $companies = Company::where(
                'id',
                $user->company_id
            )->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Dynamic Roles
        |--------------------------------------------------------------------------
        */

        $roles = $this->allowedRoles($user);

        return view(
            'invitations.create',
            compact(
                'companies',
                'roles'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (!$user->hasAnyRole(['SuperAdmin', 'Admin'])) {
            abort(
                403,
                'You are not authorized to send invitations.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Allowed Roles
        |--------------------------------------------------------------------------
        */

        $allowedRoles = $this->allowedRoles($user);

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'company_id' => [
                'required',
                'integer',
                'exists:companies,id',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'role' => [
                'required',
                'in:' . implode(',', $allowedRoles),
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin Company Protection
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Admin')) {

            if (
                (int) $validated['company_id']
                !==
                (int) $user->company_id
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'company_id' =>
                        'You can only invite users to your own company.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SuperAdmin Admin Invitation Protection
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('SuperAdmin')
            &&
            $validated['role'] === 'Admin'
        ) {

            $company = Company::findOrFail(
                $validated['company_id']
            );

            /*
            |--------------------------------------------------------------------------
            | Company must already have a user
            |--------------------------------------------------------------------------
            */

            if (!$company->users()->exists()) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'company_id' =>
                        'SuperAdmin cannot invite an Admin to a new company.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Existing Pending Invitation
        |--------------------------------------------------------------------------
        */

        $existingInvitation = Invitation::where(
            'email',
            $validated['email']
        )
            ->where(
                'company_id',
                $validated['company_id']
            )
            ->where(
                'status',
                'pending'
            )
            ->first();

        if ($existingInvitation) {

            return back()
                ->withInput()
                ->withErrors([
                    'email' =>
                    'A pending invitation already exists for this email.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Create Invitation
        |--------------------------------------------------------------------------
        */

        $invitation = Invitation::create([

            'company_id' => $validated['company_id'],

            'invited_by' => $user->id,

            'email' => $validated['email'],

            'token' => Str::random(64),

            'status' => 'pending',

            'expires_at' => now()->addDays(7),

        ]);

        /*
        |--------------------------------------------------------------------------
        | Send Email
        |--------------------------------------------------------------------------
        */

        Mail::to($invitation->email)
            ->send(
                new InvitationMail($invitation)
            );

        return redirect()
            ->route('invitations.index')
            ->with(
                'success',
                'Invitation created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(Invitation $invitation)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('SuperAdmin')) {

            // SuperAdmin can edit any invitation
        } elseif ($user->hasRole('Admin')) {

            // Admin can edit only own company invitation

            if (
                (int) $invitation->company_id
                !==
                (int) $user->company_id
            ) {

                abort(
                    403,
                    'You are not authorized to edit this invitation.'
                );
            }
        } else {

            abort(
                403,
                'You are not authorized to edit invitations.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Companies
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('SuperAdmin')) {

            $companies = Company::orderBy('name')->get();
        } else {

            $companies = Company::where(
                'id',
                $user->company_id
            )->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Dynamic Roles
        |--------------------------------------------------------------------------
        */

        $roles = $this->allowedRoles($user);

        return view(
            'invitations.edit',
            compact(
                'invitation',
                'companies',
                'roles'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Invitation $invitation
    ) {

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('SuperAdmin')) {

            // SuperAdmin can update any invitation
        } elseif ($user->hasRole('Admin')) {

            // Admin can update only own company invitation

            if (
                (int) $invitation->company_id
                !==
                (int) $user->company_id
            ) {

                return back()
                    ->withErrors([
                        'error' =>
                        'You are not authorized to update this invitation.',
                    ]);
            }
        } else {

            return back()
                ->withErrors([
                    'error' =>
                    'You are not authorized to update invitations.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Allowed Roles
        |--------------------------------------------------------------------------
        */

        $allowedRoles = $this->allowedRoles($user);

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'company_id' => [
                'required',
                'integer',
                'exists:companies,id',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'role' => [
                'required',
                'in:' . implode(',', $allowedRoles),
            ],

            'status' => [
                'required',
                'in:pending,accepted,expired',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin Company Protection
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Admin')) {

            if (
                (int) $validated['company_id']
                !==
                (int) $user->company_id
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'company_id' =>
                        'You can only use your own company.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SuperAdmin Admin Invitation Protection
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('SuperAdmin')
            &&
            $validated['role'] === 'Admin'
        ) {

            $company = Company::findOrFail(
                $validated['company_id']
            );

            if (!$company->users()->exists()) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'company_id' =>
                        'SuperAdmin cannot invite an Admin to a new company.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Update Invitation
        |--------------------------------------------------------------------------
        */

        $invitation->update([

            'company_id' => $validated['company_id'],

            'email' => $validated['email'],

            'role' => $validated['role'],

            'status' => $validated['status'],

        ]);

        return redirect()
            ->route('invitations.index')
            ->with(
                'success',
                'Invitation updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy(Invitation $invitation)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SuperAdmin
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('SuperAdmin')) {

            $invitation->delete();
        }

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */ elseif ($user->hasRole('Admin')) {

            if (
                (int) $invitation->company_id
                !==
                (int) $user->company_id
            ) {

                abort(
                    403,
                    'You are not authorized to delete this invitation.'
                );
            }

            $invitation->delete();
        }

        /*
        |--------------------------------------------------------------------------
        | Other Roles
        |--------------------------------------------------------------------------
        */ else {

            abort(
                403,
                'You are not authorized to delete invitations.'
            );
        }

        return redirect()
            ->route('invitations.index')
            ->with(
                'success',
                'Invitation deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Accept Invitation
    |--------------------------------------------------------------------------
    */

    public function accept($token)
    {
        /*
        |--------------------------------------------------------------------------
        | Find Invitation
        |--------------------------------------------------------------------------
        */

        $invitation = Invitation::where(
            'token',
            $token
        )->first();

        if (!$invitation) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Invalid invitation token.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Logged In User
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        if (!$user) {

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Please login first.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Email Protection
        |--------------------------------------------------------------------------
        */

        if (
            strtolower($invitation->email)
            !==
            strtolower($user->email)
        ) {

            abort(
                403,
                'You are not authorized to accept this invitation.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Already Accepted
        |--------------------------------------------------------------------------
        */

        if ($invitation->status === 'accepted') {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'This invitation has already been accepted.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Expiry Check
        |--------------------------------------------------------------------------
        */

        if (
            $invitation->expires_at
            &&
            $invitation->expires_at->isPast()
        ) {

            $invitation->update([
                'status' => 'expired',
            ]);

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'This invitation has expired.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Accept Invitation
        |--------------------------------------------------------------------------
        */

        $user->update([
            'company_id' => $invitation->company_id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Spatie Role Assignment
        |--------------------------------------------------------------------------
        |
        | Old:
        | $user->update(['role' => $invitation->role]);
        |
        | New:
        | Spatie manages the role through model_has_roles.
        |
        */

        $user->assignRole($invitation->role);

        /*
        |--------------------------------------------------------------------------
        | Update Invitation Status
        |--------------------------------------------------------------------------
        */

        $invitation->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Invitation accepted successfully.'
            );
    }
}
