module.exports = async (specialist_info, types, type) => {
    // loop through specialist_info
    for (let i = 0; i < specialist_info.length; i++) {
        // console log types in json format
        specialist_info[i].types = JSON.parse(specialist_info[i].types)
    }
    for (let i = 0; i < specialist_info.length; i++) {
        // check if specialist is available
        if (specialist_info[i].available === 1) {
            // check if specialist is available for the type
            if (specialist_info[i].types.includes(type)) {
                // return specialist
                return specialist_info[i].Name;
            }
        }
    }

    return null
}