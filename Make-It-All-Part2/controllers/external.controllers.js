const query = require("../utils/query.utils");
const padNumber = require("../utils/padNumber.utils");
const longDate = require("../utils/longDate.utils");
const dateDiff = require("../utils/dateDiff.utils");
const formatNoun = require("../utils/formatNoun.utils");
const formatLogNotesUtils = require("../utils/formatLogNotes.utils");

exports.externalAssignmentPageController = async (req, res) => {
    var sqlQuery = "SELECT `log`.`id`,`priority`, `problem_type`.`name` AS 'type', `created_on`,`solved_on` FROM `log` INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` WHERE `specialist_email` = ? AND NOT `status` = 'Solved';"
    const todo = await query(sqlQuery, [req.session.user.email]).catch(err => {
        console.log(err);
    })
    var todoList = [];
    var logsNullorNot = "hideElement";
    if (todo.length == 0){
        logsNullorNot = "";
    } else {
        for (var i = 0; i < todo?.length; i++) {
            var urgency = String(todo[i].priority);
            var urgencyColor = "";
            if (urgency == "-") {//Green
                urgencyColor = urgencyColor.concat("greenBox");
            } else if (urgency == "LOW") {//Yellow
                urgencyColor = urgencyColor.concat("yellowBox");
            } else if (urgency == "MEDIUM") {//Amber
                urgencyColor = urgencyColor.concat("amberBox");
            } else if (urgency == "HIGH") {//Red
                urgencyColor = urgencyColor.concat("redBox");
            }
            todoList.push({
                pId: padNumber(String(todo[i].id), 4),
                id: String(todo[i].id),
                pType: formatNoun(String(todo[i].type)),
                pUrgy: urgencyColor,
                daysSince: dateDiff(String(longDate(todo[i].created_on))),
            });
        }
    }
    res.render("myAssignmentsA", {
        navbar: { links: [
                    { url: "/specialist", text: "View All Completed Logs", underline: ""},
                    { url: "/specialist/myassignments", text: "My Assignments", underline: "horiRule" }
                    ],
                page: "Specialist",
                user: req.session.user.first_name },
        log: [],
        todo: todoList,
        logsPresent: logsNullorNot
    });
}

exports.externalAssignmentViewController = async (req, res) => {
    var sqlQuery = "SELECT `log`.`id`,`priority`, `problem_type`.`name` AS 'type', `created_on`,`solved_on` FROM `log` INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` WHERE `specialist_email` = ? AND NOT `status` = 'Solved';"
    const todo = await query(sqlQuery, [req.session.user.email]).catch(err => {
        console.log(err);
    })
    sqlQuery = "SELECT `log`.`id`, `employee_email`, `specialist_email`," +
    "`description`, `problem_type`.`name` AS 'type', `hardware`.`name` AS 'hardware'," + 
    "`software`.`name` AS 'software', `created_on`, `os`, `notes`, `Solved_on`, `status`,"+
    "`priority`, `users`.first_name AS 'fname', `users`.last_name AS 'lname' FROM `log`"+
    "INNER JOIN `users` ON `users`.`email` = `log`.`employee_email` INNER JOIN `problem_type`" +
    "ON `type_id` = `problem_type`.`id` LEFT JOIN `hardware` ON `hardware_id` = `hardware`.`id`"+
    " LEFT JOIN `software` ON `software_id` = `software`.`id` WHERE `specialist_email` = ? AND `log`.`id` = ? AND NOT `status` = 'Solved';"

    const log = await query(sqlQuery, [req.session.user.email, parseInt(req.params.id)]).catch(err => {
        console.log(err);
    })
    var todoList = [];
    var curAssigmaMale = {};

    if (todo.length == 0){
        todoNullorNot = "";
    } else {
        for (var i = 0; i < todo?.length; i++) {
            var urgency = String(todo[i].priority);
            var urgencyColor = "";
            if (urgency == "-") {//Green
                urgencyColor = urgencyColor.concat("greenBox");
            } else if (urgency == "LOW") {//Yellow
                urgencyColor = urgencyColor.concat("yellowBox");
            } else if (urgency == "MEDIUM") {//Amber
                urgencyColor = urgencyColor.concat("amberBox");
            } else if (urgency == "HIGH") {//Red
                urgencyColor = urgencyColor.concat("redBox");
            }
            todoList.push({
                pId: padNumber(String(todo[i].id), 4),
                id: String(todo[i].id),
                pType: formatNoun(String(todo[i].type)),
                pUrgy: urgencyColor,
                daysSince: dateDiff(String(longDate(todo[i].created_on))),
            });
        }
    }

    var logsNullorNot = "hideElement";
    if (log.length == 0){
        logsNullorNot = "";
    } else {
        curAssigmaMale = {
            pId: padNumber(String(log[0].id), 4),
            cName: formatNoun(String(log[0].fname).concat(String(" " + log[0].lname))),
            cEmail: String(log[0].employee_email),
            sEmail: String(log[0].specialist_email),
            pDesc: String(log[0].description),
            pType: formatNoun(String(log[0].type)),
            pHard: String(log[0].hardware),
            pSoft: String(log[0].software),
            pNotes: formatLogNotesUtils(log[0].notes),
            pCreateDate: String(longDate(log[0].created_on)),
            pSolvedDate: String(longDate(log[0].Solved_on)),
            pStat: String(log[0].status),
        };
        if(!log[0].software){
            curAssigmaMale.pSoft = '-'
        } if (!log[0].hardware) {
            curAssigmaMale.pHard = '-'
        }
    }
    res.render("myAssignmentsB", {
        navbar: { links: [
                    { url: "/specialist", text: "View All Completed Logs", underline: ""},
                    { url: "/specialist/myassignments", text: "My Assignments", underline: "horiRule" }
                    ],
                page: "Specialist",
                user: req.session.user.first_name },
        log: curAssigmaMale,
        todo: todoList,
        logsPresent: logsNullorNot
    });
}