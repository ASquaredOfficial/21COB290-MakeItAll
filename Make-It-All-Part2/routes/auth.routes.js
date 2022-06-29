const express = require("express");
const { isAdmin } = require("../middleware/auth.middleware");
const router = express.Router();
const {
  loginGetController,
  loginPostController,
  resetPasswordGetController,
  resetPasswordPostController,
  requestPasswordResetController,
  logoutController,
  sendPasswordResetEmailController,
  resetPasswordController,
} = require("./../controllers/auth.controllers");

router.get("", loginGetController);

router.post("", loginPostController);

router.get("/request_password_reset", requestPasswordResetController);

router.post("/send_email", resetPasswordPostController);

router.get("/reset_password_page/:key", resetPasswordGetController);

//router.post("/auth/register", [isAdmin],registerController);

router.get("/logout", logoutController);

module.exports = router;
