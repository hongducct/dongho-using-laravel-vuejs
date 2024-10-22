export const isAdminAuthenticated = (to, from, next) => {
  const isLoggedIn = localStorage.getItem('adminIsAuthenticated') === 'true';

  // Nếu người dùng đã đăng nhập, tiếp tục chuyển hướng tới trang yêu cầu
  if (isLoggedIn) {
    next();
  } else {
    // Nếu người dùng chưa đăng nhập và không phải trang login, chuyển hướng tới trang login
    if (to.path !== "/admin/login") {
      next("/admin/login");
    } else {
      // Nếu người dùng chưa đăng nhập và đang truy cập trang login, tiếp tục chuyển hướng tới trang login
      next();
    }
  }
};
