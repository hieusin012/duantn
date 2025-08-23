@extends('admin.layouts.index')

@section('title', 'Quản lý bình luận sản phẩm')

@section('content')
<div class="container-fluid px-0">
  <div class="card shadow-sm">
    <div class="card-body">

      <form method="GET" action="{{ route('admin.product_comments.index') }}" class="row g-2 mb-3">
        <div class="col-auto">
          <input type="text" name="keyword" class="form-control" style="min-width:320px"
                 placeholder="Tìm theo nội dung bình luận..." value="{{ $keyword }}">
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-search me-1"></i> Tìm
          </button>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th style="width:60px">#</th>
              <th>Sản phẩm</th>
              <th>Người dùng</th>
              <th>Nội dung</th>
              <th style="width:120px">Trạng thái</th>
              <th style="width:120px">Thao tác</th>
            </tr>
          </thead>
          <tbody>
          @forelse ($comments as $i => $cmt)
            <tr data-id="{{ $cmt->id }}">
              <td>{{ $comments->firstItem() + $i }}</td>
              <td>{{ $cmt->product->name ?? '—' }}</td>
              <td>{{ $cmt->user->name ?? $cmt->user->email ?? '—' }}</td>
              <td style="white-space:pre-wrap">{{ $cmt->content }}</td>
              <td>
                <span class="badge {{ $cmt->is_visible ? 'bg-success' : 'bg-secondary' }}">
                  {{ $cmt->is_visible ? 'Hiển thị' : 'Đang ẩn' }}
                </span>
              </td>
              <td>
                <button class="btn btn-sm toggle-visibility {{ $cmt->is_visible ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                  {{ $cmt->is_visible ? 'Ẩn' : 'Hiện' }}
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted">Chưa có bình luận</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      {{ $comments->links() }}

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('click', async function(e) {
  const btn = e.target.closest('.toggle-visibility');
  if (!btn) return;

  const row = btn.closest('tr');
  const id  = row.getAttribute('data-id');

  btn.disabled = true;
  try {
    const url = "{{ route('admin.product_comments.toggle', ['comment' => 'ID']) }}".replace('ID', id);
    const res = await fetch(url, {
      method: 'PATCH',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    const data = await res.json();
    if (!data.success) throw new Error('Toggle failed');

    const badge = row.querySelector('.badge');
    if (data.is_visible) {
      badge.classList.remove('bg-secondary'); badge.classList.add('bg-success');
      badge.textContent = 'Hiển thị';
      btn.classList.remove('btn-outline-success'); btn.classList.add('btn-outline-secondary');
      btn.textContent = 'Ẩn';
    } else {
      badge.classList.remove('bg-success'); badge.classList.add('bg-secondary');
      badge.textContent = 'Đang ẩn';
      btn.classList.remove('btn-outline-secondary'); btn.classList.add('btn-outline-success');
      btn.textContent = 'Hiện';
    }
  } catch (err) {
    alert('Có lỗi khi chuyển trạng thái. Vui lòng thử lại!');
    console.error(err);
  } finally {
    btn.disabled = false;
  }
});
</script>
@endpush
