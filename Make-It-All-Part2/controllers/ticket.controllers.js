const { redirect } = require('express/lib/response')
const query = require('../utils/query.utils')
const formatNoun = require('../utils/formatNoun.utils');
const shortDate = require('../utils/shortDate.utils');
const longDate = require('../utils/longDate.utils');
const dateDiff = require('../utils/dateDiff.utils');
const dbConn = require('../config/db.config')
const assignSpecialistUtils = require('../utils/assignSpecialist.utils')
const padNumber = require('../utils/padNumber.utils');
const assignSpecialistNameUtils = require('../utils/assignSpecialistName.utils');
const formatLogNotes = require('../utils/formatLogNotes.utils');
var sqlQ = "";


exports.ticketAddController = async (req, res) => {
    const email = req.session.user.email
    const description = req.body.description
    const priority = req.body.priority
    const status = 'Open'
    let newTime = new Date()
    let mysqlDate = new Date(newTime).toISOString().slice(0, 19).replace('T', ' ')
    const type = parseInt(req.body.type)
    const hardware =  req.body?.hardware ? parseInt(req.body.hardware) : null
    const software =  req.body?.software ? parseInt(req.body.software) : null
    const os = req.body.os

    const types = await query('SELECT * FROM `problem_type`', [type]).catch(err => {
        console.log(err)
    })

    if (!types) {
        res.render('/ticket?error=' + encodeURI('Error adding ticket, try again'))
        return
    }

    const specialistInfo = await query("SELECT `specialist_info`.`email`, `types`, `available`, CONCAT(`users`.`first_name`, ' ', `users`.`last_name`) AS 'Name' FROM `specialist_info` INNER JOIN `users`;").catch(err => {
        console.log(err)
    })

    if (!specialistInfo) {
        res.render('/ticket?error=' + encodeURI('Error adding ticket, try again'))
        return
    }
    const specialist_email = await assignSpecialistUtils(specialistInfo, types, type)
    
    const specialistInfo2 = await query("SELECT `specialist_info`.`email`, `types`, `available`, CONCAT(`users`.`first_name`, ' ', `users`.`last_name`) AS 'Name' FROM `specialist_info` INNER JOIN `users`;").catch(err => {
        console.log(err)
    })
    const specialist_name = await assignSpecialistNameUtils(specialistInfo2, types, type)
    var notes = "Passed straight to " + specialist_name;

    const result = await query(
        'INSERT INTO `log` (`employee_email`,`specialist_email`,`description`,`type_id`,`hardware_id`,`software_id`,`notes`,`created_on`,`os`,`priority`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?)', 
        [email, specialist_email, description, type, hardware, software, notes, mysqlDate, os, priority, status]
    )
    
    res.redirect('/ticket')
}

exports.ticketPageController = async (req, res) => {

    const error = req.query?.error ? req.query.error : null

    const problemTypes = await query('SELECT `name`, `id` FROM `problem_type`').catch(err => {
        console.log(err)
    })
    const software = await query('SELECT `name`, `id` FROM `software`').catch(err => {
        console.log(err)
    })
    const hardware = await query('SELECT `name`, `id` FROM `hardware`').catch(err => {
        console.log(err)
    })
    res.render('createTicket', {
        problemTypes,
        software,
        hardware,
        error,
        navbar: { links: [
            { url: "/ticket/mylogs", text: "View My Logs", underline: ""},
            { url: "/ticket/faqpage", text: "FAQs", underline: ""},
            { url: "/ticket", text: "Create Ticket", underline: "horiRule"}
            ],
            page: "User",
            user: req.session.user.first_name
        }
    })
}

// ticket update 
exports.ticketUpdateController = (req, res) => {
    // TODO add ticket to database
    res.redirect('/ticket')
}

// ticket delete
exports.ticketDeleteController = (req, res) => {
    // TODO add ticket to database
    res.redirect('/ticket')
}

exports.faqGetController = async (req, res) => {
    const faqs = await query('SELECT * FROM `faqs`').catch(err => {
        console.log(err)
    })
    var faqsFormatted = [];
    for (var i = 0; i < faqs?.length; i++) {
        faqsFormatted.push({
            faqId: String(padNumber(faqs[i].faq_id, 3)),
            faqQuestion: (String(faqs[i].faq_question)),
            faqAnswer: String(faqs[i].faq_answer),
            problemType: String(faqs[i].problem_type)
        });
    }
    res.render('faq', {
        faqs: faqsFormatted,
        navbar: { links: [
            { url: "/ticket/mylogs", text: "View My Logs", underline: ""},
            { url: "/ticket/faqpage", text: "FAQs", underline: "horiRule"},
            { url: "/ticket", text: "Create Ticket", underline: ""}
            ],
            page: "User",
            user: req.session.user.first_name
        }
    })
}

// My Logs Page
exports.getMyLogsController = async (req, res) => {
    var sqlQuery = ''
    if (sqlQ != '') {
        sqlQuery = sqlQ
    } else {
        sqlQuery = 
        "SELECT `log`.`id`, users.first_name AS 'fname', users.last_name AS 'lname', `description`, `problem_type`.`name` AS 'type', `hardware`.`name` AS 'hardware', `software`.`name` AS 'software', `created_on`, `status`, `priority` FROM `log` INNER JOIN `users` ON `specialist_email` = `users`.`email` INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` LEFT JOIN `hardware` ON `hardware_id` = `hardware`.`id` LEFT JOIN `software` ON `software_id` = `software`.`id` WHERE `log`.`employee_email` =  ?;"
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
            cName: formatNoun(String(logs[i].fname).concat(String(" " + logs[i].lname))),
            pDesc: String(logs[i].description),
            pType: formatNoun(String(logs[i].type)),
            pHard: String(logs[i].hardware),
            pSoft: String(logs[i].software),
            pDate: String(shortDate(logs[i].created_on)),
            pStat: String(logs[i].status),
            pUrgy: urgencyColor
        });
    }
    
    res.render('myLogsUser', {
        logs: logsFormatted,
        navbar: { links: [
            { url: "/ticket/mylogs", text: "View My Logs", underline: "horiRule"},
            { url: "/ticket/faqpage", text: "FAQs", underline: ""},
            { url: "/ticket", text: "Create Ticket", underline: ""}
            ],
            page: "User",
            user: req.session.user.first_name
        }
    })
}

exports.getFilterMyLogsController = async (req, res) => {
    sqlQ = "SELECT `log`.`id`, users.first_name AS 'fname', users.last_name AS 'lname', `description`, `problem_type`.`name` AS 'type', `hardware`.`name` AS 'hardware', `software`.`name` AS 'software', `created_on`, `status`, `priority` FROM `log` INNER JOIN `users` ON `specialist_email` = `users`.`email` INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` LEFT JOIN `hardware` ON `hardware_id` = `hardware`.`id` LEFT JOIN `software` ON `software_id` = `software`.`id` WHERE `log`.`employee_email` =  ?"
    var myquery = " AND "
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
    res.redirect('/ticket/mylogs')
    return
}

exports.userTicketDetailsController = async (req, res) => {
    logId = req.params.id //gets the id of the log the user is trying to view
    const log = await query("SELECT * FROM `log` WHERE `id` = ?", [logId]).catch(err => {
        console.log(err);
    })
    if(log.length == 0){ //redirects a user if they try to access a problem that doesn't exists
        res.redirect("/ticket/mylogs")
        return
    }
    if(req.session.user.email != log[0].employee_email){ //redirects a user if they try to access a problem that isn't theirs
        res.redirect("/ticket/mylogs")
        return
    }
    const typeName = await query("SELECT `name` FROM `problem_type` WHERE `id` = ?", [log[0].type_id]).catch(err => {
        console.log(err);
    })
    const hardwareName = await query("SELECT `name` FROM `hardware` WHERE `id` = ?", [log[0].hardware_id]).catch(err => {
        console.log(err);
    })
    const softwareName = await query("SELECT `name` FROM `software` WHERE `id` = ?", [log[0].software_id]).catch(err => {
        console.log(err);
    })
    const names = await query("SELECT `first_name`, `last_name` FROM  `users` WHERE `email` = ?", [log[0].specialist_email]).catch(err => {
        console.log(err);
    })
    var hardwareNameVal = ""; 
    if (hardwareName.length == 0){ //if hardware isn't defined in the log, replaces the value to be displayed with a '-'
        hardwareNameVal = "-"
    } else {
        hardwareNameVal = hardwareName[0].name
    }
    var softwareNameVal = "";
    if (softwareName.length == 0){ //if software isn't defined in the log, replaces the value to be displayed with a '-'
        softwareNameVal = "-"
    } else {
        softwareNameVal = softwareName[0].name
    }
    formattedData = {id: padNumber(logId),
                    requestDate: longDate(log[0].created_on),
                    solvedDate: longDate(log[0].Solved_on),
                    specialist: names[0].first_name + " " + names[0].last_name,
                    email: log[0].specialist_email,
                    software: formatNoun(softwareNameVal),
                    hardware: formatNoun(hardwareNameVal),
                    problemType: typeName[0].name,
                    description: log[0].description,
                    notes: formatLogNotes(log[0].notes),
                    solution: log[0].solution,
                    status: log[0].status }
    res.render("ticketDetailsUser", {
        navbar: { links: [
            { url: "/ticket/mylogs", text: "View My Logs", underline: "horiRule"},
            { url: "/ticket/faqpage", text: "FAQs", underline: ""},
            { url: "/ticket", text: "Create Ticket", underline: ""}
            ],
            page: "User",
            user: req.session.user.first_name },
        log: formattedData
    });
}
