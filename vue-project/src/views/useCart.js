import { ref, watch } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export function useCart() {
  const cart = ref([]);

  // Lưu giá trị của cart vào localStorage
  const saveCartToLocalStorage = () => {
    localStorage.setItem("cart", JSON.stringify(cart.value));
  };

  // Theo dõi thay đổi của cart và lưu vào localStorage
  watch(cart, saveCartToLocalStorage, { deep: true });

  const addToCart = (product) => {
    const existingProduct = cart.value.find((item) => item.id === product.id);
    // Lấy số lượng trong kho của sản phẩm
    const productStock = product.stock;

    if (existingProduct) {
      // Kiểm tra nếu thêm số lượng vào sẽ vượt quá số lượng trong kho
      if (existingProduct.quantity + product.quantity > productStock) {
        alert(`Chỉ có thể thêm tối đa ${productStock} sản phẩm vào giỏ hàng.`);
        return;
      }else {
        existingProduct.quantity += product.quantity;
        // Hiển thị thông báo thành công
        toast(`Đã thêm "${product.name}" vào giỏ hàng thành công!`, {
          autoClose: 3000,
          theme: "auto",
          type: "success",
          dangerouslyHTMLString: true,
        });
      }
      // existingProduct.quantity += product.quantity;
    } else {
      // Kiểm tra nếu số lượng thêm vào vượt quá số lượng trong kho
      if (product.quantity > productStock) {
        alert(`Chỉ có thể thêm tối đa ${productStock} sản phẩm vào giỏ hàng.`);
        return;
      }
      cart.value.push({ ...product, quantity: product.quantity });
      // Hiển thị thông báo thành công
      toast(`Đã thêm "${product.name}" vào giỏ hàng thành công!`, {
        autoClose: 3000,
        theme: "auto",
        type: "success",
        dangerouslyHTMLString: true,
      });
    }
    console.log("xx cart", cart);
    saveCartToLocalStorage(); // Lưu giỏ hàng vào localStorage
  };

  const removeFromCart = (product) => {
    const existingProduct = cart.value.find((item) => item.id === product.id);

    if (existingProduct) {
      if (existingProduct.quantity > 1) {
        existingProduct.quantity -= 1;
      } else {
        cart.value = cart.value.filter((item) => item.id !== product.id);
      }
    }

    saveCartToLocalStorage(); // Lưu giỏ hàng vào localStorage
  };

  const clearCart = () => {
    cart.value = [];
    saveCartToLocalStorage(); // Lưu giỏ hàng rỗng vào localStorage
  };

  const getTotalPrice = () => {
    return cart.value.reduce((total, item) => {
      return total + item.price * item.quantity;
    }, 0);
  };

  // Khôi phục giá trị của cart từ localStorage
  const retrieveCartFromLocalStorage = () => {
    const cartFromLocalStorage = localStorage.getItem("cart");
    if (cartFromLocalStorage) {
      cart.value = JSON.parse(cartFromLocalStorage);
    }
  };

  retrieveCartFromLocalStorage(); // Khôi phục giá trị của cart từ localStorage khi ứng dụng khởi chạy

  return {
    cart,
    addToCart,
    removeFromCart,
    clearCart,
    getTotalPrice,
  };
}
