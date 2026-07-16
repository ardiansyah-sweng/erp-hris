<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body style="font-family: sans-serif; color: #1f2937; padding: 24px;">
    <div
        style="max-width: 480px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden;">
        <div style="background: #4f46e5; padding: 20px 24px;">
            <p style="color: #fff; font-size: 12px; margin: 0; opacity: 0.8;">Pengumuman dari ERP HRIS</p>
            <h2 style="color: #fff; margin: 4px 0 0;">{{ $announcement->title }}</h2>
        </div>
        <div style="padding: 24px;">
            <p style="font-size: 14px; line-height: 1.6;">{{ $announcement->content }}</p>
            <p style="font-size: 12px; color: #6b7280; margin-top: 24px;">
                Dipublikasikan: {{ \Carbon\Carbon::parse($announcement->publish_date)->format('d M Y') }}
            </p>
        </div>
    </div>
</body>

</html>
