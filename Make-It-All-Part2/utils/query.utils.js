// promise based mysql query
const dbConn = require('../config/db.config')

const query = (queryString,values) => {
    return new Promise((resolve, reject) => {
        dbConn.query(queryString, values, (err, row, fields) => {
            if (err) reject(err)
            if (row?.length > 0) {
                resolve(row)
            } else if (row?.affectedRows > 0) { 
                resolve(row)
            }
            else {
                resolve([])
            }
        })
    })
}

module.exports = query