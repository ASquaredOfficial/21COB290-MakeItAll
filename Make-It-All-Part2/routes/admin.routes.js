// require express router
const express = require("express");
const router = express.Router();
const {
    adminPageController,
    updateAnalysisController,
    manageProblemTypesTablePageController,
    manageUserTablePageController,
    manageSoftwareTablePageController,
    manageHardwareTablePageController,
    manageFaqsTablePageController,
    editProblemTypeController,
    editUserController,
    editSoftwareController,
    editHardwareController,
    editFaqsController,
    adminAllLogsController,
    adminFilterAllLogsController,
    
    manageTransfersTablePageController,
    processTransferRequestController
} = require("../controllers/admin.controllers");

router.get("/", adminPageController);

router.post("/", updateAnalysisController);

router.get("/all_logs", adminAllLogsController);

router.post("/all_logs", adminFilterAllLogsController);

router.get("/manage/problemtypes", manageProblemTypesTablePageController);

router.get("/manage/users", manageUserTablePageController);

router.get("/manage/software", manageSoftwareTablePageController);

router.get("/manage/hardware", manageHardwareTablePageController);

router.get("/manage/faqs", manageFaqsTablePageController)

router.get("/manage/transfers", manageTransfersTablePageController);

router.post("/manage/problemtypes/:method", editProblemTypeController);

router.post("/manage/users/:method", editUserController);

router.post("/manage/software/:method", editSoftwareController);

router.post("/manage/hardware/:method", editHardwareController);

router.post("/manage/faqs/:method", editFaqsController);

router.post("/manage/transfers", processTransferRequestController);


module.exports = router;