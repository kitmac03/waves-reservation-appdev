<h1>Payment Reminder</h1>
<p>Dear {{ $reservation->customer->name ?? 'Valued Customer' }},</p>
<p>This is a friendly reminder to complete your payment for your reservation.</p>
<p><strong>Reservation Details:</strong></p>
<ul>
    <li>Date: {{ $reservation->formattedDate }}</li>
    <li>Start Time: {{ $reservation->formattedStartTime }}</li>
    <li>End Time: {{ $reservation->formattedEndTime }}</li>
    <li>Total Amount: ₱{{ number_format($reservation->grandTotal, 2) }}</li>
    <li>Paid Amount: ₱{{ number_format($reservation->paidAmount, 2) }}</li>
    <li>Remaining Balance: ₱{{ number_format($reservation->balance, 2) }}</li>
</ul>
<p>Please make your payment as soon as possible to confirm your reservation.</p>
<p>Thank you!</p>