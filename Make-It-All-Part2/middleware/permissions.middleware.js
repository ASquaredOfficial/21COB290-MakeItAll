const checkPermissions = (permission,req, res, next) => {
    if (req.user.permissions.includes(permission)) {
        next();
    } else {
        res.redirect('/');
    }
}

// permissions
module.exports = {
    canDelete : (req, res, next) => checkPermissions('delete',req, res, next),
    canUpdate : (req, res, next) => checkPermissions('update',req, res, next),
    canCreate : (req, res, next) => checkPermissions('create',req, res, next),
    canRead   : (req, res, next) => checkPermissions('read',req, res, next),
}