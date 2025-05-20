const express = require("express");
const cors = require("cors");
require("dotenv").config();

const app = express();
app.use(cors());
app.use(express.json());

const payosRoutes = require("./routes/payos");
app.use("/payos", payosRoutes);

const PORT = 4000;
app.listen(PORT, () => console.log(`PayOS Server running on http://localhost:${PORT}`));
