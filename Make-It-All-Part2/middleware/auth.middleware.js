exports.isAuthenticated = (req, res, next) => {
    if (req.session.user) {
        next();
    } else {
        res.redirect('/auth');
    }
};

// external specialist
exports.isExternal = (req, res, next) => {
    // TODO check express session for external role
    if (req.session.user.role === 'External') {
        next();
    } else {
        res.redirect('/');
    }
}

// specialist
exports.isSpecialist = (req, res, next) => {
    // TODO check express session for specialist role
    if (req.session.user.role === 'Specialist') {
        next();
    } else {
        res.redirect('/');
    }


}

// admin
exports.isAdmin = (req, res, next) => {
    if (req.session.user.role === 'Admin') {
        next();
    } else {
        res.redirect('/');
    }
}