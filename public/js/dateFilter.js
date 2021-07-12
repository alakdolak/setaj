

var start_time;
var itemsStartValue = [];
var itemsEndValue = [];
var stateValue = [];
var end_time;

for (var j = 0; j < items.length; j++) {
    itemsEndValue[j] = 1;
    itemsStartValue[j] = 1;
    stateValue[j] = 1;
}

function start() {
    start_time = document.getElementById('date_input_start').value;
    start_time = start_time.split('/');
    changeStartTime()
}

function end() {
    end_time = document.getElementById('date_input_end').value;
    end_time = end_time.split('/');
    changeEndTime();
}

function changeStartTime() {

    for (var i = 0; i < items.length; i++) {

        var day = parseInt((items[i].date.split("-")[2]));
        var month = parseInt((items[i].date.split("-")[1]));
        var year = parseInt((items[i].date.split("-")[0]));

        if (year == start_time[0]) {
            if (month == start_time[1]) {
                if (day >= start_time[2]) {
                    itemsStartValue[i] = 1;
                }
                else {
                    itemsStartValue[i] = 0;
                }
            }
            else if (month > start_time[1]) {
                itemsStartValue[i] = 1;
            }
            else {
                itemsStartValue[i] = 0;
            }
        }
        else if (year > start_time[0]) {
            itemsStartValue[i] = 1;
        }
        else {
            itemsStartValue[i] = 0;
        }
    }

}

function changeEndTime() {

    for (var i = 0; i < items.length; i++) {

        var day = parseInt((items[i].date.split("-")[2]));
        var month = parseInt((items[i].date.split("-")[1]));
        var year = parseInt((items[i].date.split("-")[0]));

        if (year == end_time[0]) {
            if (month == end_time[1]) {
                if (day <= end_time[2]) {
                    itemsEndValue[i] = 1;
                }
                else {
                    itemsEndValue[i] = 0;
                }
            }
            else if (month < end_time[1]) {
                itemsEndValue[i] = 1;
            }
            else {
                itemsEndValue[i] = 0;
            }
        }
        else if (year < end_time[0]) {
            itemsEndValue[i] = 1;
        }
        else {
            itemsEndValue[i] = 0;
        }
    }

}

function doChangeDateFilter() {

    var x = 0;

    for (var i = 0; i < items.length; i++) {

        if(!$("#myTr_" + items[i].id).hasClass('hidden')) {

            if (itemsStartValue[i] + itemsEndValue[i] + stateValue[i] != 3) {
                $("#myTr_" + items[i].id).addClass("hidden");
            }
            else {
                x++;
            }
        }

    }

    $("#totalCount").empty().append(x);
}
