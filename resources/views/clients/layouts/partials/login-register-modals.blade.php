<!-- Modal Đăng nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel"><i class="fa fa-sign-in-alt me-2 text-success"></i>Đăng nhập</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="loginEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="loginEmail" placeholder="email@example.com">
          </div>
          <div class="mb-3">
            <label for="loginPassword" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="loginPassword">
          </div>
          <button type="submit" class="btn btn-success w-100">Đăng nhập</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Đăng ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel"><i class="fa fa-user-plus me-2 text-primary"></i>Đăng ký</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="registerName" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="registerName" placeholder="Nguyễn Văn A">
          </div>
          <div class="mb-3">
            <label for="registerEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="registerEmail">
          </div>
          <div class="mb-3">
            <label for="registerPassword" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="registerPassword">
          </div>
          <div class="mb-3">
            <label for="registerPassword2" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="registerPassword2">
          </div>
          <button type="submit" class="btn btn-primary w-100">Tạo tài khoản</button>
        </form>
      </div>
    </div>
  </div>
</div>
