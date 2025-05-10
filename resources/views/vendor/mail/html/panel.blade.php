<table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
    <td class="panel-content">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
    <td class="panel-item">
    <div class="message-title">Message Content</div>
    <div class="message-content">
    {{ Illuminate\Mail\Markdown::parse($slot) }}
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>