const express = require("express");
const { isAuthenticated } = require("../middleware/auth.middleware");
const router = express.Router();

const {faqGetController} = require("../controllers/user.controllers");


router.get('/', [isAuthenticated], faqGetController);