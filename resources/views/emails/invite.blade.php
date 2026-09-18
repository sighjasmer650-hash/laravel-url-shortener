<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Invitation</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f6fa; padding:30px;">

    <div style="
        max-width:600px;
        margin:auto;
        background:white;
        padding:30px;
        border-radius:10px;
    ">

        <h2>
            You have been invited!
        </h2>

        <p>
            Hello,
        </p>

        <p>
            You have been invited to join
            <strong>{{ $invitation->company->name }}</strong>.
        </p>

        <p>
            Your assigned role is:
            <strong>{{ $invitation->role }}</strong>
        </p>

        <p>
            Please click the button below to accept the invitation.
        </p>

        <div style="margin:30px 0;">

            <a href="{{ route('invitations.accept', $invitation->id) }}"
               style="
                   background:#0d6efd;
                   color:white;
                   padding:12px 24px;
                   text-decoration:none;
                   border-radius:6px;
                   display:inline-block;
               ">
                Accept Invitation
            </a>

        </div>

        <p>
            This invitation will expire on:
            <strong>
                {{ $invitation->expires_at?->format('d M Y h:i A') }}
            </strong>
        </p>

        <p>
            Thank you.
        </p>

    </div>

</body>
</html>