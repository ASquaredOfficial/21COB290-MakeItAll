const express = require("express");
const router = express.Router();
const { 
    ticketPageController,
    ticketAddController,
    faqGetController,
    getMyLogsController,
    userTicketDetailsController,
    getFilterMyLogsController
} = require("../controllers/ticket.controllers");


//router.delete("/ticket/:id", [isAuthenticated,isSpecialist], ticketDeleteController);
router.get("/", (req, res) => {res.send("Ticket page")});

router.get('/ticket',ticketPageController);

router.post('/ticket',ticketAddController);

router.get('/ticket/faqpage', faqGetController);

router.get('/ticket/mylogs', getMyLogsController);

router.post('/ticket/mylogs', getFilterMyLogsController);

router.get('/ticket/mylogs/ticketDetails/:id', userTicketDetailsController);

//router.put('/ticket',ticketUpdateController);


module.exports = router;