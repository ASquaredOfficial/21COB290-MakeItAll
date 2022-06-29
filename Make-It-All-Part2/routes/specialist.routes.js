const express = require("express");
const router = express.Router();
const {
    specialistGetAllCompletedLogsController,
    specialistMyAssignmentsController,
    assignmentController,
    specialistTicketDetailsController,
    specialistUpdateTicketController,
    specialistGetFilterAllCompletedLogsController,

    transferTicketController
} = require("./../controllers/specialist.controllers");

router.get("/", specialistGetAllCompletedLogsController)

router.post("/", specialistGetFilterAllCompletedLogsController)

router.get("/myassignments", specialistMyAssignmentsController)

router.get("/myassignments/:id", assignmentController )

router.get("/ticketdetails/:id", specialistTicketDetailsController)

router.post("/myassignments", specialistUpdateTicketController)

router.post("/myassignments/transfer/:id", transferTicketController)

module.exports = router;