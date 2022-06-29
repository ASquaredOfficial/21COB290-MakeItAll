const nodemailer = require('nodemailer');
const dotenv = require('dotenv');
dotenv.config();



module.exports = (mailOptions) => {
    //send email to email with subject and text
    //TODO
    let transporter = nodemailer.createTransport({
        service: 'gmail',
        auth: {
            user: process.env.EMAIL,
            pass: process.env.PASSWORD
        }
    });
    transporter.sendMail(mailOptions, function(err, data) {
        if (err) {
            console.log('Error has occured: ', err);
            return 'Error has occured: ' + err;
        } else {
            console.log('Email was Sent!:');
            users.push({
                email: req.body.email,
                password: hashedPassword
            });
            return 'Email was sent!';
        }
    });

}