<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Company;

class ShortUrlController extends Controller
{
    /**
     * Display short URLs according to role.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SuperAdmin
        |--------------------------------------------------------------------------
        | SuperAdmin cannot see short URLs.
        */
        if ($user->hasRole('SuperAdmin')) {
            abort(403, 'SuperAdmin cannot access short URLs.');
        }


        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        | Admin can see all short URLs except
        | URLs created in their own company.
        */
        if ($user->hasRole('Admin')) {

            $query = ShortUrl::with(['company', 'user'])->where('company_id', $user->company_id);
        }

        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        | Member can see all short URLs except
        | URLs created by themselves.
        */ elseif ($user->hasRole('Member')) {

            $query = ShortUrl::with(['company', 'user'])
                ->where('user_id', '!=', $user->id);
        }


        /*
        |--------------------------------------------------------------------------
        | Sales / Manager
        |--------------------------------------------------------------------------
        | No restriction mentioned in the assignment.
        | They can see their company's short URLs.
        */ elseif ($user->hasAnyRole(['Sales', 'Manager'])) {

            $query = ShortUrl::with(['company', 'user'])
                ->where('company_id', $user->company_id);
        } else {
            abort(403, 'You are not authorized to access short URLs.');
        }

        /* |-------------------------------------------------------------------------- | Date Filter |-------------------------------------------------------------------------- */
        switch ($request->date_filter) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'yesterday':
                $query->whereDate('created_at', today()->subDay());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek(),]);
                break;
            case 'last_week':
                $query->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek(),]);
                break;
            case 'this_month':
                $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth(),]);
                break;
            case 'last_month':
                $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth(),]);
                break;
        } /* |-------------------------------------------------------------------------- | Get Short URLs |-------------------------------------------------------------------------- */
        $shortUrls = $query->latest()->paginate(10)->withQueryString();


        return view(
            'short-urls.index',
            compact('shortUrls')
        );
    }


    /**
     * Show create form.
     */
    public function create()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SuperAdmin, Admin and Member cannot create.
        |--------------------------------------------------------------------------
        */



        /*
        |--------------------------------------------------------------------------
        | Sales / Manager can create.
        |--------------------------------------------------------------------------
        */
        if (!$user->hasAnyRole(['Admin', 'Sales', 'Manager'])) {
            abort(
                403,
                'You are not authorized to create short URLs.'
            );
        }


        if (!$user->company_id) {
            abort(
                403,
                'You are not assigned to any company.'
            );
        }

        $companies = Company::orderBy('name')->get();
        return view('short-urls.create', ['company' => $user->company, 'companies' => $companies]);
    }


    /**
     * Store short URL.
     */

    public function store(Request $request)
    {
        $user = auth()->user();

        // Admin, Member and SuperAdmin cannot create.
        if (!$user->hasAnyRole(['Sales', 'Manager'])) {
            abort(
                403,
                'You are not authorized to create short URLs.'
            );
        }

        if (!$user->company_id) {
            abort(
                403,
                'You are not assigned to any company.'
            );
        }

        $validated = $request->validate([
            'original_url' => [
                'required',
                'url',
                'max:2048',
            ],
        ]);

        // Automatically generate unique short code
        do {
            $shortCode = Str::random(6);
        } while (
            ShortUrl::where('short_code', $shortCode)->exists()
        );

        ShortUrl::create([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'original_url' => $validated['original_url'],
            'short_code' => $shortCode,
            'clicks' => 0,
        ]);

        return redirect()
            ->route('short-urls.index')
            ->with(
                'success',
                'Short URL created successfully.'
            );
    }




    /**
     * Edit short URL.
     */
    public function edit(ShortUrl $shortUrl)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SuperAdmin cannot edit.
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('SuperAdmin')) {
            abort(
                403,
                'SuperAdmin cannot edit short URLs.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        | Admin can access URLs outside their own company.
        */
        if ($user->hasRole('Admin')) {

            if (
                (int) $shortUrl->company_id ===
                (int) $user->company_id
            ) {
                abort(
                    403,
                    'You cannot edit short URLs from your own company.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        | Member cannot edit their own URL because
        | their own URLs are not visible to them.
        */ elseif ($user->hasRole('Member')) {

            if (
                (int) $shortUrl->user_id ===
                (int) $user->id
            ) {
                abort(
                    403,
                    'You cannot edit your own short URL.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Sales / Manager
        |--------------------------------------------------------------------------
        */ elseif ($user->hasAnyRole(['Sales', 'Manager'])) {

            if (
                (int) $shortUrl->company_id !==
                (int) $user->company_id
            ) {
                abort(
                    403,
                    'You cannot edit this short URL.'
                );
            }
        }


        return view(
            'short-urls.edit',
            compact('shortUrl')
        );
    }


    /**
     * Update short URL.
     */
    public function update(
        Request $request,
        ShortUrl $shortUrl
    ) {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SuperAdmin cannot update.
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('SuperAdmin')) {
            abort(
                403,
                'SuperAdmin cannot update short URLs.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('Admin')) {

            if (
                (int) $shortUrl->company_id ===
                (int) $user->company_id
            ) {
                abort(
                    403,
                    'You cannot update short URLs from your own company.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        */ elseif ($user->hasRole('Member')) {

            if (
                (int) $shortUrl->user_id ===
                (int) $user->id
            ) {
                abort(
                    403,
                    'You cannot update your own short URL.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Sales / Manager
        |--------------------------------------------------------------------------
        */ elseif ($user->hasAnyRole(['Sales', 'Manager'])) {

            if (
                (int) $shortUrl->company_id !==
                (int) $user->company_id
            ) {
                abort(
                    403,
                    'You cannot update this short URL.'
                );
            }
        }


        $validated = $request->validate([
            'original_url' => [
                'required',
                'url',
                'max:2048',
            ],
        ]);


        $shortUrl->update([
            'original_url' => $validated['original_url'],
        ]);


        return redirect()
            ->route('short-urls.index')
            ->with(
                'success',
                'Short URL updated successfully.'
            );
    }


    /**
     * Delete short URL.
     */
    public function destroy(ShortUrl $shortUrl)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SuperAdmin cannot delete.
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('SuperAdmin')) {
            abort(
                403,
                'SuperAdmin cannot delete short URLs.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        | Admin can delete URLs outside their own company.
        */
        if ($user->hasRole('Admin')) {

            if (
                (int) $shortUrl->company_id ===
                (int) $user->company_id
            ) {
                abort(
                    403,
                    'You cannot delete short URLs from your own company.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        | Member can delete URLs NOT created by themselves.
        */ elseif ($user->hasRole('Member')) {

            if (
                (int) $shortUrl->user_id ===
                (int) $user->id
            ) {
                abort(
                    403,
                    'You cannot delete your own short URL.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Sales / Manager
        |--------------------------------------------------------------------------
        */ elseif ($user->hasAnyRole(['Sales', 'Manager'])) {

            if (
                (int) $shortUrl->company_id !==
                (int) $user->company_id
            ) {
                abort(
                    403,
                    'You cannot delete this short URL.'
                );
            }
        }


        $shortUrl->delete();


        return redirect()
            ->route('short-urls.index')
            ->with(
                'success',
                'Short URL deleted successfully.'
            );
    }
}
