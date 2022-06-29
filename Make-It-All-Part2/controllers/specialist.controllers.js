const query = require("../utils/query.utils");
const formatNoun = require("../utils/formatNoun.utils");
const padNumber = require("../utils/padNumber.utils");
const shortDate = require("../utils/shortDate.utils");
const longDate = require("../utils/longDate.utils");
const dateDiff = require("../utils/dateDiff.utils");
const formatLogNotesUtils = require("../utils/formatLogNotes.utils");
var sqlQ = "";

exports.specialistGetAllCompletedLogsController = async (req, res) => {
  // query for all logs
  var sqlQuery = ''
  if (sqlQ != '') {
      sqlQuery = sqlQ
  } else {
      sqlQuery = 
      "SELECT `log`.id, users.first_name AS 'fname', users.last_name AS 'lname', `description`, `problem_type`.`name` AS 'type', " +
      "`hardware`.`name` AS 'hardware', `software`.`name` AS 'software', `created_on`, `Solved_on`, `status`, `priority` " +
      "FROM `log` " +
      "INNER JOIN `users` ON `users`.email = `log`.employee_email " +
      "INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` " +
      "LEFT JOIN `hardware` ON `hardware_id` = `hardware`.`id` " +
      "LEFT JOIN `software` ON `software_id` = `software`.`id` " +
      "WHERE `status` = 'Solved';";
  }
  const logs = await query(sqlQuery, [req.session.user.email]).catch((err) => {
    console.log(err);
  });
  var logsFormatted = [];
  for (var i = 0; i < logs?.length; i++) {
    var urgency = String(logs[i].priority);
    var urgencyColor = "";
    if (urgency == "-") {
      //Green
      urgencyColor = urgencyColor.concat("status_null");
    } else if (urgency == "LOW") {
      //Yellow
      urgencyColor = urgencyColor.concat("status_low");
    } else if (urgency == "MEDIUM") {
      //Amber
      urgencyColor = urgencyColor.concat("status_medium");
    } else if (urgency == "HIGH") {
      //Red
      urgencyColor = urgencyColor.concat("status_high");
    }
    if (!logs[i].software) {
      logs[i].software = "-";
    }
    if (!logs[i].hardware) {
      logs[i].hardware = "-";
    }
    logsFormatted.push({
      pId: padNumber(String(logs[i].id), 4),
      cName: formatNoun(
        String(logs[i].fname).concat(String(" " + logs[i].lname)),
      ),
      pDesc: String(logs[i].description),
      pType: formatNoun(String(logs[i].type)),
      pHard: String(logs[i].hardware),
      pSoft: String(logs[i].software),
      pDateC: String(shortDate(logs[i].created_on)),
      pDateS: String(shortDate(logs[i].Solved_on)),
      pUrgy: urgencyColor,
    });
  }
  // specialist view
  res.render("specialist", {
    navbar: {
      links: [
        {
          url:
            req.session.user.role.toUpperCase() == "SPECIALIST"
              ? "/specialist"
              : "/external",
          text: "View All Completed Logs",
          underline: "horiRule",
        },
        {
          url:
            (req.session.user.role.toUpperCase() == "SPECIALIST"
              ? "/specialist"
              : "/external") + "/myassignments",
          text: "My Assignments",
          underline: "",
        },
      ],
      page: "Specialist",
      user: req.session.user.first_name,
    },
    logs: logsFormatted,
  });
};

exports.specialistGetFilterAllCompletedLogsController = async (req, res) => {
    sqlQ = 
    "SELECT `log`.id, users.first_name AS 'fname', users.last_name AS 'lname', `description`, `problem_type`.`name` AS 'type', "+
    "`hardware`.`name` AS 'hardware', `software`.`name` AS 'software', `created_on`, `Solved_on`, `status`, `priority` "+
    "FROM `log` " +
    "INNER JOIN `users` ON `users`.email = `log`.employee_email " +
    "INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` " +
    "LEFT JOIN `hardware` ON `hardware_id` = `hardware`.`id` " +
    "LEFT JOIN `software` ON `software_id` = `software`.`id` " +
    "WHERE `status` = 'Solved'"
    console.log(sqlQ)
    var myquery = " AND "
    var queryChanged = false;
    var first = true;
    //Filter Initial Date SQL
    if (req.body.filterDate1 != "" || req.body.filterDate2 != ""){
        var date2 = req.body.filterDate2;
        if (req.body.filterDate2 == ""){ //replace date 2 with today if empty string
            var date2 = shortDate(new Date());
        }
        myquery += "log.created_on >= '" + req.body.filterDate1 + "' AND log.created_on <= '" + date2 + "'";
        first = false;
        queryChanged = true;
    }
    //Filter Solved Date SQL
    if (req.body.filterDate3 != "" || req.body.filterDate4 != ""){
        if (first){ 
            first = false;
        } else {
            myquery += " AND "
        }

        var date4 = req.body.filterDate4;
        if (req.body.filterDate4 == ""){ //replace date 4 with today if empty string
            var date4 = shortDate(new Date());
        }
        myquery += "log.Solved_on >= '" + req.body.filterDate3 + "' AND log.Solved_on <= '" + date4 + "'";
        first = false;
        queryChanged = true;
    }
    console.log(myquery);
    if (queryChanged) {
        sqlQ += myquery
    }
    res.redirect(req.session.user.role == 'Specialist'?'/specialist':'/external');
    return
}

exports.specialistMyAssignmentsController = async (req, res) => {
  var sqlQuery =
    "SELECT `log`.`id`,`priority`, `problem_type`.`name` AS 'type', `created_on`,`solved_on` FROM `log` INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` WHERE `specialist_email` = ? AND NOT `status` = 'Solved';";
  const todo = await query(sqlQuery, [req.session.user.email]).catch((err) => {
    console.log(err);
  });
  var todoList = [];
  var logsNullorNot = "hideElement";
  if (todo.length == 0) {
    logsNullorNot = "";
  } else {
    for (var i = 0; i < todo?.length; i++) {
      var urgency = String(todo[i].priority);
      var urgencyColor = "";
      if (urgency == "-") {
        //Green
        urgencyColor = urgencyColor.concat("greenBox");
      } else if (urgency == "LOW") {
        //Yellow
        urgencyColor = urgencyColor.concat("yellowBox");
      } else if (urgency == "MEDIUM") {
        //Amber
        urgencyColor = urgencyColor.concat("amberBox");
      } else if (urgency == "HIGH") {
        //Red
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
    navbar: {
      links: [
        {
          url:
            req.session.user.role.toUpperCase() == "SPECIALIST"
              ? "/specialist"
              : "/external",
          text: "View All Completed Logs",
          underline: "",
        },
        {
          url:
            (req.session.user.role.toUpperCase() == "SPECIALIST"
              ? "/specialist"
              : "/external") + "/myassignments",
          text: "My Assignments",
          underline: "horiRule",
        },
      ],
      page: "Specialist",
      user: req.session.user.first_name,
    },
    log: [],
    todo: todoList,
    logsPresent: logsNullorNot,
  });
};

exports.assignmentController = async (req, res) => {
  var sqlQuery =
    "SELECT `log`.`id`,`priority`, `problem_type`.`name` AS 'type', `created_on`,`solved_on` FROM `log` INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` WHERE `specialist_email` = ? AND NOT `status` = 'Solved';";
  const todo = await query(sqlQuery, [req.session.user.email]).catch((err) => {
    console.log(err);
  });
  sqlQuery =
    "SELECT `log`.`id`, `employee_email`, `specialist_email`, employees.department, employees.phone_number," +
    "`description`, `problem_type`.`name` AS 'type', `hardware`.`name` AS 'hardware'," +
    "`software`.`name` AS 'software', `created_on`, `os`, `notes`, `Solved_on`, `status`," +
    "`priority`, `users`.first_name AS 'fname', `users`.last_name AS 'lname' " +
    "FROM `log` " +
    "INNER JOIN `users` ON `users`.`email` = `log`.`employee_email` " + 
    "INNER JOIN employees ON employees.email = log.employee_email " +
    "INNER JOIN `problem_type` ON `type_id` = `problem_type`.`id` " + 
    "LEFT JOIN `hardware` ON `hardware_id` = `hardware`.`id` " +
    "LEFT JOIN `software` ON `software_id` = `software`.`id` " + 
    "WHERE `specialist_email` = ? AND `log`.`id` = ? AND NOT `status` = 'Solved';";

  const log = await query(sqlQuery, [
    req.session.user.email,
    parseInt(req.params.id),
  ]).catch((err) => {
    console.log(err);
  });
  var todoList = [];
  var curAssigmaMale = {};

  if (todo.length == 0) {
    todoNullorNot = "";
  } else {
    for (var i = 0; i < todo?.length; i++) {
      var urgency = String(todo[i].priority);
      var urgencyColor = "";
      if (urgency == "-") {
        //Green
        urgencyColor = urgencyColor.concat("greenBox");
      } else if (urgency == "LOW") {
        //Yellow
        urgencyColor = urgencyColor.concat("yellowBox");
      } else if (urgency == "MEDIUM") {
        //Amber
        urgencyColor = urgencyColor.concat("amberBox");
      } else if (urgency == "HIGH") {
        //Red
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
  if (log.length == 0) {
    logsNullorNot = "";
  } else {
    curAssigmaMale = {
      pId: padNumber(String(log[0].id), 4),
      cName: formatNoun(log[0].fname + " " + log[0].lname) + ", from " + log[0].department,
      phoneNo: String(log[0].phone_number),
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
    if (!log[0].software) {
      curAssigmaMale.pSoft = "-";
    }
    if (!log[0].hardware) {
      curAssigmaMale.pHard = "-";
    }
  }
  res.render("myAssignmentsB", {
    navbar: {
      links: [
        {
          url:
            req.session.user.role.toUpperCase() == "SPECIALIST"
              ? "/specialist"
              : "/external",
          text: "View All Completed Logs",
          underline: "",
        },
        {
          url:
            (req.session.user.role.toUpperCase() == "SPECIALIST"
              ? "/specialist"
              : "/external") + "/myassignments",
          text: "My Assignments",
          underline: "horiRule",
        },
      ],
      page: "Specialist",
      user: req.session.user.first_name,
    },
    log: curAssigmaMale,
    todo: todoList,
    logsPresent: logsNullorNot,
  });
};

exports.specialistTicketDetailsController = async (req, res) => {
  logId = req.params.id;
  const log = await query("SELECT * FROM `log` WHERE `id` = ?", [logId]).catch(
    (err) => {
      console.log(err);
    },
  );
  const empDetails = await query(
    "SELECT * FROM `employees` WHERE `email` = ?",
    [log[0].employee_email],
  ).catch((err) => {
    console.log(err);
  });
  const typeName = await query(
    "SELECT `name` FROM `problem_type` WHERE `id` = ?",
    [log[0].type_id],
  ).catch((err) => {
    console.log(err);
  });
  const hardwareName = await query(
    "SELECT `name` FROM `hardware` WHERE `id` = ?",
    [log[0].hardware_id],
  ).catch((err) => {
    console.log(err);
  });
  const softwareName = await query(
    "SELECT `name` FROM `software` WHERE `id` = ?",
    [log[0].software_id],
  ).catch((err) => {
    console.log(err);
  });
  const names = await query(
    "SELECT `first_name`, `last_name` FROM  `users` WHERE `email` = ?",
    [log[0].employee_email],
  ).catch((err) => {
    console.log(err);
  });
  var hardwareNameVal = "";
  if (hardwareName.length == 0) {
    hardwareNameVal = "-";
  } else {
    hardwareNameVal = hardwareName[0].name;
  }
  var softwareNameVal = "";
  if (softwareName.length == 0) {
    softwareNameVal = "-";
  } else {
    softwareNameVal = softwareName[0].name;
  }
  formattedData = {
    id: padNumber(logId),
    requestDate: longDate(log[0].created_on),
    employee:
      names[0].first_name +
      " " +
      names[0].last_name +
      " from " +
      empDetails[0].department +
      ". " +
      empDetails[0].phone_number,
    software: formatNoun(softwareNameVal),
    hardware: formatNoun(hardwareNameVal),
    problemType: typeName[0].name,
    description: log[0].description,
    notes: formatLogNotesUtils(log[0].notes),
    solution: log[0].solution,
  };
  res.render("ticketDetailsSpecialist", {
    navbar: {
      links: [
        {
          url:
            req.session.user.role.toUpperCase() == "SPECIALIST"
              ? "/specialist"
              : "/external",
          text: "View All Completed Logs",
          underline: "horiRule",
        },
        {
          url:
            (req.session.user.role.toUpperCase() == "SPECIALIST"
              ? "/specialist"
              : "/external") + "/myassignments",
          text: "My Assignments",
          underline: "",
        },
      ],
      page: "Specialist",
      user: req.session.user.first_name,
    },
    log: formattedData,
  });
};

exports.specialistUpdateTicketController = async (req, res) => {
  var id = req.body.ticketID;
  var notes = req.body.addNotes;
  var resolved = req.body.resolvedBox;
  var newDate = longDate(new Date());
  if (!resolved) {
    //append notes to notes
    var sql1 = "SELECT `notes` FROM `log` WHERE `id` = ?";
    const currNotes = await query(sql1, [id]).catch((err) => {
      console.log(err);
    });
    var newNotes = String(currNotes[0].notes) + " | " + newDate + " ~ " + notes;
    var sql2 = "UPDATE `log` SET `notes`= ? WHERE `id` = ?";
    const doUpdate = await query(sql2, [newNotes, id]).catch((err) => {
      console.log(err);
    });
    res.redirect("./" + id);
  } else {
    var solvedDate = new Date().toISOString().slice(0, 19).replace("T", " ");
    var sql =
      "UPDATE `log` SET `solution`= ?, `solved_on` = ?, `status` = 'Solved', `priority` = '0' WHERE `id` = ?";
    const doUpdate2 = await query(sql, [notes, solvedDate, id]).catch((err) => {
      console.log(err);
    });
    res.redirect(".");
  }
};

exports.transferTicketController = async (req, res) => {
  const result = query(
    "Insert Into `transfer_requests` (`log_id`,`original_specialist`) values (?,?)",
    [req.params.id, req.session.user.email],
  ).catch((err) => {
    console.log(err);
  });
  const result2 = query('UPDATE `log` SET `status` = "Transfer Requested", `` WHERE `id` = ?', [req.params.id]).catch((err) => {
    console.log(err)
  })
  if (result) {
    res.redirect("..");
  } else {
    res.redirect("..");
  }
};
