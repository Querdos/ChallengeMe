/**
 * Created by querdos on 3/23/17.
 */

// highlight for syntax coloration
hljs.initHighlightingOnLoad();

// vars for the counter
var timeSpent   = $("#chronotime");
var end;

function elapsed(begin, end) {
    var start = moment(begin, "MM-DD-YY HH:mm:ss");

    var diff  = end.diff(start, 'seconds');
    var seconds = diff - Math.floor(diff/60)*60;
    var minutes = Math.floor(diff/60) - Math.floor((Math.floor(diff/60)/60))*60;
    var hours   = Math.floor(Math.floor(diff/60)/60);

    var toString = "";
    if (hours > 0) {
        toString += hours + " h, ";
    }

    if (minutes > 0) {
        toString += minutes + " min, ";
    }

    toString += seconds + " sec";
    return toString;
}
