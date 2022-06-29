const dbConn = require("../config/db.config")
const query = require("../utils/query.utils")
const formatNoun = require('../utils/formatNoun.utils');
const shortDate = require('../utils/shortDate.utils');
const padNumber = require('../utils/padNumber.utils');
var sqlQ = "";

// adming page
exports.adminPageController = async (req, res) => {
    var startDate = "2022-01-01"
    var endDate = "2022-01-31"
    const logDates = await query("SELECT CAST(created_on AS DATE) date FROM log  ORDER BY DATE ASC")
    var listDates = []
    var listDatesQuantity = []
    for(var i = 0; i < logDates.length; i++){
        var newForm = shortDate(logDates[i].date)
        if(listDates.indexOf(newForm) == -1){
            listDates[listDates.length] = newForm
            listDatesQuantity[listDates.length-1] = 1
        }else{
            listDatesQuantity[listDates.indexOf(newForm)] = listDatesQuantity[listDates.indexOf(newForm)] + 1
        }
    }
    const hardRes = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 1 AND status = "Solved"')
    const hardUnres = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 1 AND status = "Open"')
    const softRes = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 2 AND status = "Solved"')
    const softUnres = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 2 AND status = "Open"')
    const netRes = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 3 AND status = "Solved"')
    const netUnres = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 3 AND status = "Open"')
    const hardBar = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 1')
    const softBar = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 2')
    const netBar = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 3')
    const hardDonutData = [hardRes[0].num, hardUnres[0].num]
    const softDonutData = [softRes[0].num, softUnres[0].num]
    const netDonutData = [netRes[0].num, netUnres[0].num]
    const barChartData = [hardBar[0].num, softBar[0].num, netBar[0].num]
    res.render('admin', {
        navbar: {
            user: req.session.user.first_name,
            links: [
                { url: '/admin/manage/users', text: 'Manage', underline: ""}, 
                { url: '/admin/all_logs', text: 'All Logs', underline: "" },
                { url: '/admin', text: 'Analysis', underline: "horiRule" },
            ],
            page: 'Admin'
        },
        startDate,
        endDate,
        hardDonutData,
        softDonutData,
        netDonutData,
        barChartData,
        listDates,
        listDatesQuantity
    })
}

exports.updateAnalysisController = async (req, res) => {
    var startDate = req.body.date_start
    var endDate = req.body.date_end
    const logDates = await query("SELECT CAST(created_on AS DATE) date FROM log WHERE created_on BETWEEN ? and ?", [startDate, endDate])
    var listDates = []
    var listDatesQuantity = []
    for(var i = 0; i < logDates.length; i++){
        var newForm = shortDate(logDates[i].date)
        if(listDates.indexOf(newForm) == -1){
            listDates[listDates.length] = newForm
            listDatesQuantity[listDates.length-1] = 1
        }else{
            listDatesQuantity[listDates.indexOf(newForm)] = listDatesQuantity[listDates.indexOf(newForm)] + 1
        }
    }
    const hardRes = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 1 AND status = "Solved" AND created_on BETWEEN ? and ?', [startDate, endDate])
    const hardUnres = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 1 AND status = "Open" AND created_on BETWEEN ? and ?', [startDate, endDate])
    const softRes = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 2 AND status = "Solved" AND created_on BETWEEN ? and ?', [startDate, endDate])
    const softUnres = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 2 AND status = "Open" AND created_on BETWEEN ? and ?', [startDate, endDate])
    const netRes = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 3 AND status = "Solved" AND created_on BETWEEN ? and ?', [startDate, endDate])
    const netUnres = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 3 AND status = "Open" AND created_on BETWEEN ? and ?', [startDate, endDate])
    const hardBar = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 1 AND created_on BETWEEN ? and ?', [startDate, endDate])
    const softBar = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 2 AND created_on BETWEEN ? and ?', [startDate, endDate])
    const netBar = await query('SELECT COUNT(*) AS num FROM log WHERE type_id = 3 AND created_on BETWEEN ? and ?', [startDate, endDate])
    const hardDonutData = [hardRes[0].num, hardUnres[0].num]
    const softDonutData = [softRes[0].num, softUnres[0].num]
    const netDonutData = [netRes[0].num, netUnres[0].num]
    const barChartData = [hardBar[0].num, softBar[0].num, netBar[0].num];
    res.render('admin', {
        navbar: {
            user: req.session.user.first_name,
            links: [
                { url: '/admin/manage/users', text: 'Manage', underline: ""}, 
                { url: '/admin/all_logs', text: 'All Logs', underline: "" },
                { url: '/admin', text: 'Analysis', underline: "horiRule" },
            ],
            page: 'Admin'
        },
        startDate,
        endDate,
        hardDonutData,
        softDonutData,
        netDonutData,
        barChartData,
        listDates,
        listDatesQuantity
    })
}

// All Logs Page
exports.adminAllLogsController = async (req, res) => {
    var sqlQuery = ''
    if (sqlQ != '') {
        sqlQuery = sqlQ
    } else {
        sqlQuery = 
        "SELECT `log`.`id`, `log`.`employee_email`, `log`.`specialist_email`, `description`, `problem_type`.`name` AS 'type', `hardware`.`name` AS 'hardware', `software`.`name` AS 'software', `created_on`, `status`, `priority` FROM `log` INNER JOIN `users` ON `specialist_email` = `users`.`email` INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` LEFT JOIN `hardware` ON `hardware_id` = `hardware`.`id` LEFT JOIN `software` ON `software_id` = `software`.`id`;"
    }
    const logs = await query(sqlQuery, [req.session.user.email]).catch(err => {
        console.log(err);
    })
    console.log(sqlQuery)
    var logsFormatted = [];
    for (var i = 0; i < logs?.length; i++) {
        var urgency = String(logs[i].priority);
        var urgencyColor = "";
        if (urgency == "-") {//Green
            urgencyColor = urgencyColor.concat("status_null");
        } else if (urgency == "LOW") {//Yellow
            urgencyColor = urgencyColor.concat("status_low");
        } else if (urgency == "MEDIUM") {//Amber
            urgencyColor = urgencyColor.concat("status_medium");
        } else if (urgency == "HIGH") {//Red
            urgencyColor = urgencyColor.concat("status_high");
        } 
        if (!logs[i].software) {
            logs[i].software = '-'
        } if (!logs[i].hardware) {
            logs[i].hardware = '-'
        }
        logsFormatted.push({
            pId: padNumber(String(logs[i].id), 4),
            uEmail: logs[i].employee_email,
            sEmail: logs[i].specialist_email,
            pType: formatNoun(String(logs[i].type)),
            pHard: String(logs[i].hardware),
            pSoft: String(logs[i].software),
            pDate: String(shortDate(logs[i].created_on)),
            pStat: String(logs[i].status),
            pUrgy: urgencyColor
        });
    }
    
    res.render('allLogs', {
        logs: logsFormatted,
        navbar: {
            user: req.session.user.first_name,
            links: [
                { url: '/admin/manage/users', text: 'Manage', underline: ""}, 
                { url: '/admin/all_logs', text: 'All Logs', underline: "horiRule" },
                { url: '/admin', text: 'Analysis', underline: "" },
            ],
            page: 'Admin'
        }
    });
}

exports.adminFilterAllLogsController = async (req, res) => {
    sqlQ = "SELECT `log`.`id`, `log`.`employee_email`, `log`.`specialist_email`, `description`, `problem_type`.`name` AS 'type', `hardware`.`name` AS 'hardware', `software`.`name` AS 'software', `created_on`, `status`, `priority` FROM `log` INNER JOIN `users` ON `specialist_email` = `users`.`email` INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` LEFT JOIN `hardware` ON `hardware_id` = `hardware`.`id` LEFT JOIN `software` ON `software_id` = `software`.`id`"
    var myquery = " WHERE "
    var queryChanged = false;
    var first = true;
    //Filter Date Filter
    if (req.body.filterDate1 != "" || req.body.filterDate2 != ""){
        var date2 = req.body.filterDate2;
        if (req.body.filterDate2 == ""){ //replace date 2 with today if empty string
            var date2 = shortDate(new Date());
            //console.log("new 2nd date: " + date2);
        }
        myquery += "log.created_on >= '" + req.body.filterDate1 + "' AND log.created_on <= '" + date2 + "'";
        console.log(myquery);
        first = false;
        queryChanged = true;
    }

    //Filter Status SQL
    if (req.body.openBox == 'on' || req.body.pendingBox == 'on' || req.body.solvedBox == 'on') {
        if (first){ 
            first = false;
        } else {
            myquery += " AND "
        }

        var firstStatus = true;
        if (req.body.openBox == 'on') {
            firstStatus = false;
            myquery += "log.status = 'Open'"
            console.log("Open Ticket Variable is defined.");
        } if (req.body.pendingBox == 'on') {
            if (firstStatus){
                firstStatus = false;
            } else{
                myquery += " OR "
            }
            myquery += "log.status = 'Pending'"
            console.log("Pending Ticket Variable is defined.");
        } if (req.body.solvedBox == 'on') {
            if (firstStatus){
                firstStatus = false;
            } else{
                myquery += " OR "
            }
            myquery += "log.status = 'Solved'"
            console.log("Solved Ticket Variable is defined.");
        } 
        queryChanged = true;
    } 
    
    //Filter Priority SQl 
    if (req.body.closedBox == 'on' || req.body.lowBox == 'on' || req.body.mediumBox == 'on' || req.body.highBox == 'on') {
        if (first){ 
            first = false;
        } else {
            myquery += " AND "
        }
    
        var firstPriority = true;
        if (req.body.closedBox == 'on') {
            firstPriority = false;
            myquery += "log.priority = '-'"
            console.log("Open Ticket Variable is defined.");
        } if (req.body.lowBox == 'on') {
            if (firstPriority){
                firstPriority = false;
            } else{
                myquery += " OR "
            }
            myquery += "log.priority = 'LOW'"
            console.log("Pending Ticket Variable is defined.");
        } if (req.body.mediumBox == 'on') {
            if (firstPriority){
                firstPriority = false;
            } else{
                myquery += " OR "
            }
            myquery += "log.priority = 'MEDIUM'"
            console.log("Solved Ticket Variable is defined.");
        } if (req.body.highBox == 'on') {
            if (firstPriority){
                firstPriority = false;
            } else{
                myquery += " OR "
            }
            myquery += "log.priority = 'HIGH'"
            console.log("Solved Ticket Variable is defined.");
        } 
        queryChanged = true;
    }    
    if (queryChanged) {
        sqlQ += myquery
    }
    res.redirect('/admin/all_logs')
    return
}

//manage controllers
exports.manageUserTablePageController = async (req, res) => {
    const users = await query(`SELECT users.email, users.first_name, users.last_name, users.role, employees.department, employees.phone_number, employees.job_title FROM users LEFT JOIN employees ON users.email=employees.email`).catch(err => {
        console.log(err)
    })
    var userList = [];
    for (var i = 0; i < users?.length; i++) {
        if(users[i].role == "Employee"){
            userList.push({
                email: String(users[i].email),
                firstname: formatNoun(String(users[i].first_name)),
                lastname: formatNoun(String(users[i].last_name)),
                role: String(users[i].role),
                department: String(users[i].department),
                phoneno: String(users[i].phone_number),
                jobtitle: String(users[i].job_title),
            });
        }else{
            userList.push({
                email: String(users[i].email),
                firstname: formatNoun(String(users[i].first_name)),
                lastname: formatNoun(String(users[i].last_name)),
                role: String(users[i].role),
                department: "-",
                phoneno: "-",
                jobtitle: "-"
            });
        }
    }
    res.render('manageUsers', {
        navbar: {
            user: req.session.user.first_name,
            links: [
                { url: '/admin/manage/users', text: 'Manage', underline: "horiRule"},
                { url: '/admin/all_logs', text: 'All Logs', underline: "" }, 
                { url: '/admin', text: 'Analysis', underline: "" }
            ],
            page: 'Admin'
        },
        button_links : [
            {url: '/admin/manage/users', text: 'Users', underline: "manageButtonsBold"}, 
            {url: '/admin/manage/problemtypes', text: 'Problem Types', underline: "noUnderline"}, 
            {url: '/admin/manage/software', text: 'Software', underline: "noUnderline"}, 
            {url: '/admin/manage/hardware', text: 'Hardware', underline: "noUnderline"}, 
            {url: '/admin/manage/faqs', text: 'FAQs', underline: "noUnderline"}, 
            {url: '/admin/manage/transfers', text: 'Transfers', underline: "noUnderline"}, 
        ],
        pageTitle: 'Users',
        data: userList
    })
}

exports.manageProblemTypesTablePageController = async (req, res) => {
    const problemTypes = await query(`SELECT * FROM problem_type`).catch(err => {
        console.log(err)
    })
    var problemTypeList = [];
    for (var i = 0; i < problemTypes?.length; i++) {
        if(problemTypes[i].parent_type == null){
            problemTypeList.push({
                id: String(problemTypes[i].id),
                name: formatNoun(String(problemTypes[i].name)),
                parentId: "-"
            });
        }else{
            problemTypeList.push({
                id: String(problemTypes[i].id),
                name: formatNoun(String(problemTypes[i].name)),
                parentId: String(problemTypes[i].parent_type)
            });  
        }
    }
    res.render('manageProblemTypes', {
        navbar: {
            user: req.session.user.first_name,
            links: [
                { url: '/admin/manage/users', text: 'Manage', underline: "horiRule"},
                { url: '/admin/all_logs', text: 'All Logs', underline: "" },  
                { url: '/admin', text: 'Analysis', underline: "" }
            ],
            page: 'Admin',
        },
        button_links : [
            {url: '/admin/manage/users', text: 'Users', underline: "noUnderline"}, 
            {url: '/admin/manage/problemtypes', text: 'Problem Types', underline: "manageButtonsBold"}, 
            {url: '/admin/manage/software', text: 'Software', underline: "noUnderline"}, 
            {url: '/admin/manage/hardware', text: 'Hardware', underline: "noUnderline"},
            {url: '/admin/manage/faqs', text: 'FAQs', underline: "noUnderline"}, 
            {url: '/admin/manage/transfers', text: 'Transfers', underline: "noUnderline"}, 
        ],
        pageTitle: 'Problem Types',
        data: problemTypeList
    })
}

exports.manageSoftwareTablePageController = async (req, res) => {
    const software = await query(`SELECT * FROM software`).catch(err => {
        console.log(err)
    })
    var softwareList = [];
    for (var i = 0; i < software?.length; i++) {
        softwareList.push({
            id: String(software[i].id),
            name: formatNoun(String(software[i].name)),
        });
    }
    res.render('manageSoftware', {
        navbar: {
            user: req.session.user.first_name,
            links: [
                { url: '/admin/manage/software', text: 'Manage', underline: "horiRule"}, 
                { url: '/admin/all_logs', text: 'All Logs', underline: "" },  
                { url: '/admin', text: 'Analysis', underline: "" }
            ],
            page: 'Admin'
        },
        button_links : [
            {url: '/admin/manage/users', text: 'Users', underline: "noUnderline"}, 
            {url: '/admin/manage/problemtypes', text: 'Problem Types', underline: "noUnderline"}, 
            {url: '/admin/manage/software', text: 'Software', underline: "manageButtonsBold"}, 
            {url: '/admin/manage/hardware', text: 'Hardware', underline: "noUnderline "}, 
            {url: '/admin/manage/faqs', text: 'FAQs', underline: "noUnderline"}, 
            {url: '/admin/manage/transfers', text: 'Transfers', underline: "noUnderline"}, 
        ],
        pageTitle: 'Software',
        data: softwareList
    })
}

exports.manageHardwareTablePageController = async (req, res) => {
    const hardware = await query(`SELECT * FROM hardware`).catch(err => {
        console.log(err)
    })
    var hardwareList = [];
    for (var i = 0; i < hardware?.length; i++) {
        hardwareList.push({
            id: String(hardware[i].id),
            name: formatNoun(String(hardware[i].name)),
        });
    }
    res.render('manageHardware', {
        navbar: {
            user: req.session.user.first_name,
            links: [
                { url: '/admin/manage/hardware', text: 'Manage', underline: "horiRule"}, 
                { url: '/admin/all_logs', text: 'All Logs', underline: "" },  
                { url: '/admin', text: 'Analysis', underline: "" }
            ],
            page: 'Admin'
        },
        button_links : [
            {url: '/admin/manage/users', text: 'Users', underline: "noUnderline"}, 
            {url: '/admin/manage/problemtypes', text: 'Problem Types', underline: "noUnderline"}, 
            {url: '/admin/manage/software', text: 'Software', underline: "noUnderline"}, 
            {url: '/admin/manage/hardware', text: 'Hardware', underline: "manageButtonsBold"}, 
            {url: '/admin/manage/faqs', text: 'FAQs', underline: "noUnderline"}, 
            {url: '/admin/manage/transfers', text: 'Transfers', underline: "noUnderline"}, 
        ],
        pageTitle: 'Hardware',
        data: hardwareList
    })
}

exports.manageFaqsTablePageController = async (req, res) => {
    const faqs = await query(`SELECT faqs.faq_id, faqs.faq_question, faqs.faq_answer, problem_type.name FROM faqs INNER JOIN problem_type ON faqs.problem_type = problem_type.id`).catch(err => {
        console.log(err)
    })
    var faqList = [];
    for (var i = 0; i < faqs?.length; i++) {
        faqList.push({
            id: String(faqs[i].faq_id),
            question: String(faqs[i].faq_question),
            answer: String(faqs[i].faq_answer),
            problemType: formatNoun(String(faqs[i].name))
        });
    }
    res.render('manageFAQs', {
        navbar: {
            user: req.session.user.first_name,
            links: [
                { url: '/admin/manage/faqs', text: 'Manage', underline: "horiRule"}, 
                { url: '/admin/all_logs', text: 'All Logs', underline: "" },  
                { url: '/admin', text: 'Analysis', underline: "" }
            ],
            page: 'Admin'
        },
        button_links : [
            {url: '/admin/manage/users', text: 'Users', underline: "noUnderline"}, 
            {url: '/admin/manage/problemtypes', text: 'Problem Types', underline: "noUnderline"}, 
            {url: '/admin/manage/software', text: 'Software', underline: "noUnderline"}, 
            {url: '/admin/manage/hardware', text: 'Hardware', underline: "noUnderline"}, 
            {url: '/admin/manage/faqs', text: 'FAQs', underline: "manageButtonsBold"},
            {url: '/admin/manage/transfers', text: 'Transfers', underline: "noUnderline"}, 
        ],
        pageTitle: 'FAQs',
        data: faqList
    })
}


exports.manageTransfersTablePageController = async (req, res) => {
    const transfers = await query('SELECT * FROM `transfer_requests` where `reassigned_specialist` IS NULL').catch(err => {
        console.log(err)
    })
    const specialists = await query('SELECT * FROM `users` where `role` = "Specialist"').catch(err => {
        console.log(err)
    })
    const external = await query('SELECT * FROM `users` where `role` = "External"').catch(err => {
        console.log(err)
    })
    console.log(specialists,external)
    res.render('manageTransfers', {
        navbar: {
            user: req.session.user.first_name,
            links: [
                { url: '/admin/manage/faqs', text: 'Manage', underline: "horiRule"}, 
                { url: '/admin', text: 'Analysis', underline: "" }
            ],
            page: 'Admin'
        },
        button_links : [
            {url: '/admin/manage/users', text: 'Users', underline: "noUnderline"}, 
            {url: '/admin/manage/problemtypes', text: 'Problem Types', underline: "noUnderline"}, 
            {url: '/admin/manage/software', text: 'Software', underline: "noUnderline"}, 
            {url: '/admin/manage/hardware', text: 'Hardware', underline: "noUnderline"}, 
            {url: '/admin/manage/faqs', text: 'FAQs', underline: "noUnderline"}, 
            {url: '/admin/manage/transfers', text: 'Transfers', underline: "manageButtonsBold"}, 
        ],
        pageTitle: 'Transfers',
        data: transfers,
        specialists: {specialists, external},
    

    })
}

exports.processTransferRequestController = async (req, res) => {
    const {transfer_id, assigned} = req.body

    const transfer = await query(`SELECT * FROM transfer_requests WHERE id = ${transfer_id}`).catch(err => {
        console.log(err)
    })
    const log = await query('UPDATE `log` SET `specialist_email` = ? WHERE `id` = ?', [assigned, transfer[0].log_id]).catch(err => {
        console.log(err)
    })
    const result = await query(`UPDATE transfer_requests SET reassigned_specialist = "${assigned}" WHERE id = ${transfer_id}`).catch(err => {
        console.log(err)
    })
    if (result) {
        res.redirect('/admin/manage/transfers')
    } else {
        res.redirect('/admin/manage/transfers')
    }
}


exports.editUserController = async (req, res) => {
    console.log('Attempting Edit of user')
    const method = req.params.method
    switch (method) {
        case "POST":
        case "post":
            return addUserController(req, res)

        case "PUT":
        case "put":
            return updateUserController(req, res)

        case "DELETE":
        case "delete":
            return deleteUserController(req, res)

        default:
            res.redirect('/admin/manage/users')
            break;
    }
}

exports.editProblemTypeController = async (req, res) => {
    const method = req.params.method
    switch (method) {
        case "POST":
        case "post":
            return addProblemTypesController(req, res)
            
        case "PUT":
        case "put":
            return updateProblemTypesController(req, res)
            
        case "DELETE":
        case "delete":
            return deleteProblemTypesController(req, res)
            
        default:
            res.redirect('/admin/manage/problemtypes')
            break;
    }
}

exports.editSoftwareController = async (req, res) => {
    const method = req.params.method
    switch (method) {
        case "POST":
        case "post":
            return addSoftwareController(req, res)
            
        case "PUT":
        case "put":
            return updateSoftwareController(req, res)
            
        case "DELETE":
        case "delete":
            return deleteSoftwareController(req, res)
            
        default:
            res.redirect('/admin/manage/software')
            break;
    }
}

exports.editHardwareController = async (req, res) => {
    const method = req.params.method
    switch (method) {
        case "POST":
        case "post":
            return addHardwareController(req, res)

        case "PUT":
        case "put":
            return updateHardwareController(req, res)
            
        case "DELETE":
        case "delete":
            return deleteHardwareController(req, res)
            
        default:
            res.redirect('/admin/manage/hardware')
            break;
    }
}

exports.editFaqsController = async (req, res) => {
    const method = req.params.method
    switch (method) {
        case "POST":
        case "post":
            return addFaqsController(req, res)

        case "PUT":
        case "put":
            return updateFaqsController(req, res)
            
        case "DELETE":
        case "delete":
            return deleteFaqsController(req, res)
            
        default:
            res.redirect('/admin/manage/faqs')
            break;
    }
}

//add controllers
const addUserController = async (req, res) => {
    if(req.body.role == "Employee"){
        var sql1 = "INSERT INTO users (email, password, first_name, last_name, role) VALUES (?,?,?,?,?)"
        var sql2 = "INSERT INTO employees (email, department, phone_number, job_title) VALUES (?,?,?,?)"
        var params1 = [req.body.email, "password", req.body.firstname, req.body.lastname, req.body.role]
        var params2 = [req.body.email, req.body.department, req.body.phone_number, req.body.job_title]
        const result1 = query(sql1, params1)
        const result2 = query(sql2, params2)
        if (result1 && result2) {
            res.redirect('/admin/manage/users')
            return
        }
        res.redirect('/admin/manage/users')
        return
    }else{
        var sql = "INSERT INTO users (email, password, first_name, last_name, role) VALUES (?,?,?,?,?)"
        var params = [req.body.email, "password", req.body.firstname, req.body.lastname, req.body.role]
        const result = query(sql, params)
        if (result) {
            res.redirect('/admin/manage/users')
            return
        }
        res.redirect('/admin/manage/users')
        return
    }
}

const addProblemTypesController = async (req, res) => {
    const result = query(`INSERT INTO problem_type (name, parent_type) VALUES (?,?)`,
     [req.body.name, req.body.problem_type])
    if (result) {
        res.redirect('/admin/manage/problemtypes')
        return
    }
    res.redirect('/admin/manage/problemtypes')
    return
}

const addSoftwareController = async (req, res) => {
    const result = query(`INSERT INTO software (name) VALUES (?)`, [req.body.name])
    if (result) {
        res.redirect('/admin/manage/software')
        return
    }
    res.redirect('/admin/manage/software')
    return
}

const addHardwareController = async (req, res) => {
    const result = query(`INSERT INTO hardware (name) VALUES (?)`, [req.body.name])
    if (result) {
        res.redirect('/admin/manage/hardware')
        return
    }
    res.redirect('/admin/manage/hardware')
    return
}

const addFaqsController = async (req, res) => {
    const result = query(`INSERT INTO faqs (faq_question, faq_answer, problem_type) VALUES (?,?,?)`, [req.body.question, req.body.answer, req.body.problem_type])
    if (result) {
        res.redirect('/admin/manage/faqs')
        return
    }
    res.redirect('/admin/manage/faqs')
    return
}

//delete controllers
const deleteUserController = async (req, res) => {
    const result1 = query(`DELETE FROM users WHERE email = ?`, [req.body.email])
    const result2 = query(`DELETE FROM employees WHERE email = ?`, [req.body.email])
    if (result1 && result2) {
        res.redirect('/admin/manage/users')
        return
    }
    res.redirect('./admin/manage/users')
    return   
}

const deleteProblemTypesController = async (req, res) => {
    const result = query(`DELETE FROM problem_type WHERE id = ?`, [req.body.id])
    if (result) {
        res.redirect('/admin/manage/problemtypes')
        return
    }
    res.redirect('./admin/manage/problemtypes')
    return
}

 const deleteSoftwareController = async (req, res) => {
    const result = query(`DELETE FROM software WHERE id = ?`, [req.body.id])
    if (result) {
        res.redirect('/admin/manage/software')
        return
    }
    res.redirect('./admin/manage/software')  
    return
}

 const deleteHardwareController = async (req, res) => {
    const result = query(`DELETE FROM hardware WHERE id = ?`, [req.body.id])
    if (result) {
        res.redirect('/admin/manage/hardware')
        return
    }
    res.redirect('./admin/manage/hardware')
    return
}

const deleteFaqsController = async (req, res) => {
    const result = query(`DELETE FROM faqs WHERE faq_id = ?`, [req.body.id])
    if (result) {
        res.redirect('/admin/manage/faqs')
        return
    }
    res.redirect('./admin/manage/faqs')
    return
}

//update controllers
const updateUserController = async (req, res) => {
    var sqlQuery = "UPDATE `users` SET"
    var first = true;
    if (req.body.first_name != ""){//If fname not empty then add it to the query
        first = false;
        sqlQuery += " first_name = '" + req.body.first_name + "'";
    } 
    if (req.body.last_name != ""){//If lname not empty then add it to the query
        if(first){
            first = false;
        }else{
            sqlQuery += ","
        }
        sqlQuery += " last_name = '" + req.body.last_name + "'";
    } 
    var sqlQuery2 = "UPDATE `employees` SET"
    var second = true
    if(req.body.department != ""){
        second = false;
        sqlQuery2 += " department = '" + req.body.department + "'";
    }
    if(req.body.teleno != ""){
        if(second){
            second = false;
        }else{ 
            sqlQuery2 += ","
        }
        sqlQuery2 += " phone_number = '" + req.body.teleno + "'";
    }
    if(req.body.job_title != ""){
        if(second){
            second = false;
        }else{
            sqlQuery2 += ","
        }
        sqlQuery2 += " job_title = '" + req.body.job_title + "'"
    }
    if(!first && !second){
        const result1 = query(sqlQuery + " WHERE `email` = ?", [req.body.email])
        const result2 = query(sqlQuery2 + " WHERE `email` = ?", [req.body.email])
        if (result1 && result2) {
            res.redirect('/admin/manage/users')
            return
        }
        res.redirect('/admin/manage/users')
        return
    }else if(!first){
        const result = query(sqlQuery + " WHERE `email` = ?", [req.body.email])
        if (result) {
            res.redirect('/admin/manage/users')
            return
        }
        res.redirect('/admin/manage/users')
        return
    }else if(!second){
        const result = query(sqlQuery2 + " WHERE `email` = ?", [req.body.email])
        if (result) {
            res.redirect('/admin/manage/users')
            return
        }
        res.redirect('/admin/manage/users')
        return
    }else{
        res.redirect('/admin/manage/users')
        return
    }
}

const updateProblemTypesController = async (req, res) => {
    var sqlQuery = "UPDATE `problem_type` SET"
    var first = true;
    if (req.body.name != ""){
        first = false;
        sqlQuery += " name = '" + req.body.name + "'";
    } 
    if (req.body.parent_id != ""){
        if(first){
            first = false;
        }else{
            sqlQuery += ","
        }
        sqlQuery += " parent_type = '" + req.body.parent_id + "'";
    } 
    if(!first){
        const result = query(sqlQuery + " WHERE `id` = ?", [req.body.id])
        if (result) {
            res.redirect('/admin/manage/problemtypes')
            return
        }
        res.redirect('/admin/manage/problemtypes')
        return
    }
    res.redirect('/admin/manage/problemtypes')
    return
}

const updateSoftwareController = async (req, res) => {
    if (req.body.name != ""){
        sqlQuery = "UPDATE software SET name = ? WHERE id = ?"
        const result = query(sqlQuery, [req.body.name, req.body.id])
        if (result) {
            res.redirect('/admin/manage/software')
            return
        }
        res.redirect('/admin/manage/software')
        return
    } 
    res.redirect('/admin/manage/software')
    return
}

const updateHardwareController = async (req, res) => {
    if (req.body.name != ""){
        sqlQuery = "UPDATE hardware SET name = ? WHERE id = ?"
        const result = query(sqlQuery, [req.body.name, req.body.id])
        if (result) {
            res.redirect('/admin/manage/hardware')
            return
        }
        res.redirect('/admin/manage/hardware')
        return
    } 
    res.redirect('/admin/manage/hardware')
    return
}

const updateFaqsController = async (req, res) => {
    var sqlQuery = "UPDATE `faqs` SET"
    var first = true;
    if (req.body.question != ""){
        first = false;
        sqlQuery += " faq_question = '" + req.body.question + "'";
    } 
    if (req.body.answer != ""){
        if(first){
            first = false;
        }else{
            sqlQuery += ","
        }
        sqlQuery += " faq_answer = '" + req.body.answer + "'";
    } 
    if (req.body.problem_type != ""){
        var typeId = 1
        console.log(req.body.problem_type)
        if(req.body.problem_type == "Software"){
            typeId = 2
        }else if(req.body.problem_type == "Network"){
            typeId = 3
        }
        console.log(typeId)
        if(first){
            first = false;
        }else{
            sqlQuery += ","
        }
        sqlQuery += " problem_type = '" + typeId + "'";
        console.log(sqlQuery)
    } 
    if(!first){
        const result = query(sqlQuery + " WHERE `faq_id` = ?", [req.body.id])
        if (result) {
            res.redirect('/admin/manage/faqs')
            return
        }
        res.redirect('/admin/manage/faqs')
        return
    }
    res.redirect('/admin/manage/faqs')
    return
}
