const { redirect } = require('express/lib/response')
const dbConn = require('../config/db.config')
const genPass = require('../utils/genPass.utils')
const genUrlKey = require('../utils/genUrlKey.utils')
const sendEmailUtil = require('../utils/sendEmail.utils')
const bcrypt = require('bcrypt');
const query = require('../utils/query.utils')

// login get controller
exports.loginGetController = (req, res) => {
    res.render('login', { 
        message: undefined,
        showDiv: '' })
}

// login post controller
exports.loginPostController = async (req, res) => {
    let error;

    if (!req.body?.email || !req.body?.password) {
        res.render('login', {
            message: 'Please enter/fill in both fields',
            showDiv: 'showElement'
        });
        return
    }

    // check if user exists
    const result = await query('SELECT * FROM `users` WHERE `email` = ?', [req.body.email]).then(data => {
        if (data?.length > 0) {
            if (bcrypt.compareSync(req.body.password, data[0].password)) {
                return data[0]
            } else {
                return undefined
            }
        }
    }).catch(err => {
        console.log(err)
    })    
    if (!result) {
        res.render('login', {
            message: 'Incorrect email or password',
            showDiv: 'showElement'
        });
        return
    }

    req.session.user = result

    // checks what type of user is logged in
    switch (result?.role) {
        case 'Admin':
            res.redirect('/admin')
            break;
        case 'Specialist':
            res.redirect('/specialist')
            break;
        case 'External':
            res.redirect('/external')
            break;
        default:
            res.redirect('/ticket')
            break;
    }
}

// password reset code
exports.requestPasswordResetController = (req, res) => {
    res.render('requestPassword')
}
exports.resetPasswordPostController = (req, res) => {

    // create password reset url
    key = genUrlKey(8)
    // url to password reset page
    url = 'http://localhost:3000/auth/reset_password_page/' + key

    // sends email to user
    let currentTime = new Date()
    let newTime = currentTime.setHours(currentTime.getHours() + 8)

    let mysqlDate = new Date(newTime).toISOString().slice(0, 19).replace('T', ' ')
    dbConn.query('Insert INTO `resetUrl` (`employee_email`,`reset_url`,`expire`) VALUES (?,?,?)', [req.body.email, key, mysqlDate], (err, row, fields) => {
        if (err) throw err
        if (row.affectedRows > 0) {
            let mailOptions = {
                from: 'team004lboro@gmail.com',
                to: req.body.email,
                subject: 'Password reset',
                text: url + "\nThis link is valid for 8 hours. If you did not request a new password, then ignore this email.\n\nHelpdesk Service,\nMake It All"
            };
            try {
                sendEmailUtil(mailOptions)
                res.render('emailSentStatus', { message: 'Email sent' })
            } catch (error) {
                res.render('emailSentStatus', { message: 'Email not sent' })
            }
        } else {
            res.render('emailSentStatus', { message: 'Incorrect email' })
        }
    })
}

exports.resetPasswordControllerPage = (req, res) => {
    res.render('resetPassword')
}

exports.resetPasswordGetController = async (req, res) => {
    const key = req.params.key
    newPassword = genPass(6)
    const hashedPassword = await bcrypt.hash(newPassword, 10)
    //update password in database
    let message;
    let updated = false;
    let keyResults = await query('SELECT * FROM `reseturl` WHERE `reset_url` = ?', [key]).catch(err => {
        console.log(err)
    })
    if (keyResults) {
        let affected = await query('UPDATE `users` SET `password` = ? WHERE `email` = ?', [hashedPassword, keyResults[0].employee_email]).catch(err => {
            console.log(err)
        })
        if (affected?.affectedRows > 0) {
            message = 'Password updated'
            updated = true
        } else {
            message = 'Password not updated'
        }
        //delete reset url from database
        await query('DELETE FROM `resetUrl` WHERE `employee_email` = ?', [keyResults[0].email]).catch(err => {
            console.log(err)
        })
    } else {
        message = 'Invalid key'
    }
    res.render('resetPassword', { message: message, password: updated ? newPassword : '' })

}


// logout controller
exports.logoutController = (req, res) => {
    if (req.session.user) {
        delete req.session.user; 
        res.redirect('/');
    } else {
        res.redirect('/');
    }

}