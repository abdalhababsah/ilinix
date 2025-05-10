<tr>
    <td>
    <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
    <td class="content-cell" align="center">
    {{ Illuminate\Mail\Markdown::parse($slot) }}
    
    <p>This is an automated notification from the {{ config('app.name') }} platform. Please do not reply directly to this email.</p>
    </td>
    </tr>
    </table>
    </td>
    </tr>