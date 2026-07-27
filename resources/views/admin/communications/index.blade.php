@extends('layouts.admin')
@section('title', 'Communication')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Messages Sent</h5>
        <a href="{{ route('admin.communications.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Compose Message</a>
    </div>
    <div class="alert alert-info m-3">
    Email sends via your configured mail driver. SMS uses Africa's Talking, WhatsApp uses Meta's Cloud API &mdash; both need credentials set in <code>.env</code> to actually deliver (see <code>config/services.php</code>). Without those, messages are logged as failed rather than silently dropped.
</div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Subject</th><th>Channel</th><th>Audience</th><th>Recipients</th><th>Status</th><th>Sent</th><th></th></tr></thead>
            <tbody>
            @forelse ($communications as $c)
                <tr>
                    <td>{{ $c->subject }}</td>
                    <td><span class="badge bg-label-secondary">{{ strtoupper($c->channel) }}</span></td>
                    <td>{{ str_replace('_',' ',ucfirst($c->audience)) }}</td>
                    <td>{{ $c->recipients_count }}</td>
                    <td><span class="badge bg-label-{{ $c->status==='sent'?'success':($c->status==='failed'?'danger':'secondary') }}">{{ ucfirst($c->status) }}</span></td>
                    <td>{{ optional($c->sent_at)->format('d M Y H:i') }}</td>
                    <td class="text-end">
                        <form action="{{ route('admin.communications.destroy',$c) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message record?');">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-icon text-danger"><i class="bx bx-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No messages sent yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $communications->links() }}</div>
</div>
@endsection
