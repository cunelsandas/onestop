
$('.datepick').datepicker({
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true,
    language: "th-th"
});

function Splitdate(date) {
    if (date != '') {
        date = date.split('/');
        date[2] = date[2] - 543;
        date = date[2] + '-' + date[1] + '-' + date[0];
    }
    return date;
}
function SplitAr(date) {
    if (date != '') {
        date = date.split('/');
        date = date[0];
    }
    return date;
}

function DateT(n) {
    if (n != null && n != '') {
        var SHdate = new Date(n)

        function ga(date) {
            return date < 10 ? "0" + date : date;
        }
        return ga(SHdate.getDate()) + '/' + ga((SHdate.getMonth() + 1)) + '/' + (SHdate.getFullYear() + 543);
    } else {
        return '';
    }

};
var DateNow = new Date();
DateNow = DateT(DateNow);

var TextEdit = (function () {
    function Number(num) {
        return num != null && num != undefined && num != 0 ? parseFloat(num).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") : '';
    };

    function NumberString(num) {
        return num != null && num != undefined && num != 0 ? parseFloat(num).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") : '';
    };

    function Text(text) {
        return text == null ? '' : text;
    };

    // function DateT(n) {
    //     if(n != ''){
    //         var SHdate = new Date(n)
    //         function ga(date) {
    //             return date < 10 ? "0" + date : date;
    //         }
    //         return ga(SHdate.getDate()) + '/' + ga((SHdate.getMonth() + 1)) + '/' + (SHdate.getFullYear() + 543);
    //     }else {
    //         return '';
    //     }
    //
    // };
    //

})();

function Textnull(text) {
    return text == null ? '' : text;
};
