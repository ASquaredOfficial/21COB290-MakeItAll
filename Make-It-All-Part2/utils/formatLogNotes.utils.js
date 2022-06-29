module.exports = (logNotes) => {
    var noteStrings = logNotes.split('|')
    var noteList = []
    for (var i = 0; i < noteStrings.length; i++){
        var theNote = noteStrings[i].trim()
        var notePair = []
        if (i == 0) {
            noteList.push( [theNote] )
        } else if (i > 0){
            theNote = theNote.split('~')
            var noteDate = theNote[0].trim()
            var noteString = theNote[1].trim()
            notePair.push(noteDate, noteString)
            noteList.push( notePair )
        }
    }
    return noteList
}
    