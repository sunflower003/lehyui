const express = require("express");
const router = express.Router();
const PayOS = require("@payos/node");
require("dotenv").config();

const payos = new PayOS(
  process.env.PAYOS_CLIENT_ID,
  process.env.PAYOS_API_KEY,
  process.env.PAYOS_CHECKSUM_KEY
);

router.post("/create", async (req, res) => {
  try {
    const { orderCode, amount, description } = req.body;

    const shortDesc = description.slice(0, 25);
    const paymentLink = await payos.createPaymentLink({
      orderCode,
      amount,
      description: shortDesc,
      returnUrl: "http://localhost:8000/donate/return",  // ✅ Link sau thanh toán thành công
      cancelUrl: "http://localhost:8000",                 // ✅ Link khi người dùng bấm huỷ
      items: [],                                          // 👈 Có thể để rỗng nếu không có danh sách hàng hoá
    });

    res.json({ checkoutUrl: paymentLink.checkoutUrl });
  } catch (err) {
    console.error(err);
    res.status(500).json({ message: "Lỗi khi tạo liên kết thanh toán" });
  }
});

module.exports = router;
