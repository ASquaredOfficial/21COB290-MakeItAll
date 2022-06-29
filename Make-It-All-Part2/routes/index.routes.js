const express = require('express');
const router = express.Router();
const AuthRouter = require('./auth.routes');
const SpecialistRouter = require('./specialist.routes');
const TicketRouter = require('./ticket.routes');
const AdminRouter = require('./admin.routes');
const ExternalRouter = require('./external.routes');
const {
  isAuthenticated,
  isAdmin,
  isSpecialist
} = require('./../middleware/auth.middleware');



router.use('/auth',AuthRouter);
router.use('/', [isAuthenticated],TicketRouter);
router.use('/admin', [isAuthenticated,isAdmin],AdminRouter);
router.use('/specialist', [isAuthenticated,isSpecialist],SpecialistRouter);
router.use('/external', [isAuthenticated],ExternalRouter)

module.exports = router;
