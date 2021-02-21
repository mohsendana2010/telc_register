/*jshint esversion: 6 */
// import scrollLock from "scroll-lock";
import langMessage from "../translations/locales/en.js";
import {i18n} from "../translations/i18n";
const moment = require('moment');

export default class Helper {

  static fillFormatData(comand, dataj) {
    const formData = new FormData();
    formData.append('command', comand);

    for (var prop in dataj) {
      formData.append(prop, dataj[prop]);
    }
    return formData;
  }

  static makeTableHeader(tableName, headerField) {
    let header = [];

    for (let i = 0; i < headerField.length; i++) {
      header.push({
        text: i18n.t(`${tableName}.${headerField[i]}`),
        align: 'start',
        sortable: true,
        value: headerField[i],

      });
    }
    header.push({text: i18n.t('actions'), value: 'actions', sortable: false, width: "2%"});
    return header;
  }

  static makeAgGridHeader(tableName, headerField, headerFilter, withId) {
    var filterParams = {
      comparator: function (filterLocalDateAtMidnight, cellValue) {
        var dateAsString = cellValue;
        if (dateAsString == null) return -1;
        var dateParts = dateAsString.split('-');
        var cellDate = new Date(
          Number(dateParts[0]),
          Number(dateParts[1]) - 1,
          Number(dateParts[2])
        );
        if (filterLocalDateAtMidnight.getTime() === cellDate.getTime()) {
          return 0;
        }
        if (cellDate < filterLocalDateAtMidnight) {
          return -1;
        }
        if (cellDate > filterLocalDateAtMidnight) {
          return 1;
        }
      },
      browserDatePicker: true,
      minValidYear: 1950,
    };

    let headerFilterItems = [
      "agNumberColumnFilter",
        "agTextColumnFilter",
        "agDateColumnFilter",
        "agSetColumnFilter",
    ];
    let header = [
      {
        headerName: i18n.t('row'),
        field: 'row',
        headerCheckboxSelection: true,
        headerCheckboxSelectionFilteredOnly: true,
        checkboxSelection: true,
        filter: 'agNumberColumnFilter',
        pinned: 'left',
      },
    ];
    for (let i = 0; i < headerField.length; i++) {
      if ( headerField[i].toLowerCase() !== "id") {
        if (headerFilterItems[headerFilter[i]] === "agDateColumnFilter"){
          header.push({
            headerName: i18n.t(`${tableName}.${headerField[i]}`),
            field:  headerField[i],
            filter: headerFilterItems[headerFilter[i]],
            filterParams: filterParams,
            cellRenderer: (params) => {
              return moment(params.value).format("DD.MM.YYYY");
            },
          });
        } else {
          header.push({
            headerName: i18n.t(`${tableName}.${headerField[i]}`),
            field:  headerField[i],
            filter: headerFilterItems[headerFilter[i]],
          });
        }
      } else if (withId) {
        header.push({
          headerName: i18n.t(`${tableName}.${headerField[i]}`),
          field:  headerField[i],
          filter: headerFilterItems[headerFilter[i]],
        });
      }
    }
    return header;
  }

  static makedefaultItem(headerField) {
    let defaultItem=  {};
    for (let i = 0; i < headerField.length; i++) {
      defaultItem[headerField[i]]="";
    }
    return defaultItem;
  }


  static cloneObject(obj) {
    let copy;
    // Handle the 3 simple types, and null or undefined
    if (null == obj || "object" != typeof obj) return obj;
    copy = JSON.stringify(obj);
    return JSON.parse(copy);
  }

  static loadjscssfile(filename, filetype) {
    var fileref = "";
    if (filetype == "js") {
      //if filename is a external JavaScript file
      fileref = document.createElement("script");
      fileref.setAttribute("type", "text/javascript");
      fileref.setAttribute("src", filename);
      fileref.setAttribute("async", false);
    } else if (filetype == "css") {
      //if filename is an external CSS file
      fileref = document.createElement("link");
      fileref.setAttribute("rel", "stylesheet");
      fileref.setAttribute("type", "text/css");
      fileref.setAttribute("href", filename);
    }
    if (fileref != "")
      document.getElementsByTagName("head")[0].appendChild(fileref);
  }

  static removejscssfile(filename, filetype) {
    var targetelement =
      filetype == "js" ? "script" : filetype == "css" ? "link" : "none"; //determine element type to create nodelist from
    var targetattr =
      filetype == "js" ? "src" : filetype == "css" ? "href" : "none"; //determine corresponding attribute to test for
    var allsuspects = document.getElementsByTagName(targetelement);
    for (var i = allsuspects.length; i >= 0; i--) {
      //search backwards within nodelist for matching elements to remove
      if (
        allsuspects[i] &&
        allsuspects[i].getAttribute(targetattr) != null &&
        allsuspects[i].getAttribute(targetattr).indexOf(filename) != -1
      )
        allsuspects[i].parentNode.removeChild(allsuspects[i]); //remove element by calling parentNode.removeChild()
    }
  }
  // static getUserAgent() {
  //   // Opera 8.0+
  //   var isOpera =
  //     (!!window.opr && !!opr.addons) ||
  //     !!window.opera ||
  //     navigator.userAgent.indexOf(" OPR/") >= 0;
  //
  //   // Firefox 1.0+
  //   var isFirefox = typeof InstallTrigger !== "undefined";
  //
  //   // Safari 3.0+ "[object HTMLElementConstructor]"
  //   var isSafari =
  //     /constructor/i.test(window.HTMLElement) ||
  //     (function(p) {
  //       return p.toString() === "[object SafariRemoteNotification]";
  //     })(!window.safari || safari.pushNotification);
  //
  //   // Internet Explorer 6-11
  //   var isIE = /*@cc_on!@*/ false || !!document.documentMode;
  //
  //   // Edge 20+
  //   var isEdge = !isIE && !!window.StyleMedia;
  //
  //   // Chrome 1+
  //   var isChrome =
  //     !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
  //
  //   // Blink engine detection
  //   var isBlink = (isChrome || isOpera) && !!window.CSS;
  //
  //   return isOpera
  //     ? "Opera"
  //     : isFirefox
  //       ? "Firefox"
  //       : isSafari
  //         ? "Safari"
  //         : isChrome
  //           ? "Chrome"
  //           : isIE
  //             ? "IE"
  //             : isEdge
  //               ? "Edge"
  //               : isBlink
  //                 ? "Blink"
  //                 : "Don't know";
  // }

  // static isMobile() {
  //   var check = false;
  //   (function(a) {
  //     if (
  //       /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
  //         a
  //       ) ||
  //       /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
  //         a.substr(0, 4)
  //       )
  //     )
  //       check = true;
  //   })(navigator.userAgent || navigator.vendor || window.opera);
  //   this.isMobileClient = check;
  //   return check;
  // }

  static addZeroBehind10(num) {
    if (parseInt(num) < 10) {
      num = "0" + num;
    }
    return num;
  }

  //=AlertHandler==========================
  static showAlert(app, alertMsg, alertType) {
    app.showAlertDialog = true;
    app.alertType = alertType; //success, info, warning or error
    app.alertMsg = alertMsg;
    if (alertMsg == "Session expired!") {
      setTimeout(function () {
        window.location.href = window.location.origin;
      }, 3000);
    }
  }

  static getCurrentDayOfWeek(day) {
    if (day == 1) return langMessage.monday;
    else if (day == 2) return langMessage.tuesday;
    else if (day == 3) return langMessage.wednesday;
    else if (day == 4) return langMessage.thursday;
    else if (day == 5) return langMessage.friday;
    else if (day == 6) return langMessage.saturday;
    else if (day == 0) return langMessage.sunday;
    else return "False Number";
  }

  static getCurrentMonthName(month) {
    //month = 6
    var months = [
      "Januar",
      "Februar",
      "März",
      "April",
      "Mai",
      "Juni",
      "Juli",
      "August",
      "September",
      "Oktober",
      "November",
      "Dezember",
      "False Number"
    ];
    if (month < 12 && month >= 0) {
      return months[month];
    } else {
      return months[12];
    }
  }

  static convDate2Day_2(date) {
    if (!date) return null;

    const [year, month, day] = date.split("-");
    var days = this.convDate2Day(
      parseInt(year),
      parseInt(month),
      parseInt(day)
    );
    return days;
  }

  static dateComparison(firstDate, lastDate) {
    var day1 = this.convDate2Day_2(firstDate);
    var day2 = this.convDate2Day_2(lastDate);
    return day2 - day1;
  }

  static convDate2Day(year, month, day) {
    var temp = 0;
    year -= 1;
    temp += year * 365;
    temp += parseInt(year / 4);
    year += 1;
    if (month > 0 && month < 13) {
      switch (month) {
        case 1:
          temp += 0;
          break;
        case 2:
          temp += 31;
          break;
        case 3:
          temp += 59;
          break;
        case 4:
          temp += 90;
          break;
        case 5:
          temp += 120;
          break;
        case 6:
          temp += 151;
          break;
        case 7:
          temp += 181;
          break;
        case 8:
          temp += 212;
          break;
        case 9:
          temp += 243;
          break;
        case 10:
          temp += 273;
          break;
        case 11:
          temp += 304;
          break;
        case 12:
          temp += 334;
          break;
      }
    } else {
      return 0;
    }
    if (day > 0 && day < 32) {
      temp += day;
    } else {
      return 0;
    }
    if (year % 4 == 0 && month >= 3) {
      temp += 1;
    }
    return temp;
  }

  static setCurrentDateYearMonthDayAsString() {
    // return year + "-" + month + "-" + day;
    var date = new Date();
    return this.setDateYearMonthDayAsString(date);
  }

  static setDateYearMonthDayAsString(date) {
    // return year + "-" + month + "-" + day;
    var day = this.addZeroBehind10(date.getDate());
    var month = this.addZeroBehind10(date.getMonth() + 1);
    var year = date.getFullYear();
    var newDate = year + "-" + month + "-" + day;
    return newDate;
  }

  static getReadableDateStringFromDate(date) {
    // return day + "." + month + "." + year;
    var day = this.addZeroBehind10(date.getDate());
    var month = this.addZeroBehind10(date.getMonth() + 1);
    var year = date.getFullYear();
    var currentDate = day + "." + month + "." + year;
    return currentDate;
  }

  static parseDateStringReturnDate(dateString) {
    var year = dateString.substring(0, 4);
    var month = dateString.substring(5, 7) - 1;
    var day = dateString.substring(8, 10);
    var hour = dateString.substring(11, 13);
    var minute = dateString.substring(14, 16);
    var second = dateString.substring(17, 19);
    var offset = dateString.substring(20, 25);
    var offsetInHours = parseInt(offset) / 100;
    var offsetInMs = offsetInHours * 1000 * 60 * 60;
    return new Date(
      Date.UTC(year, month, day, hour, minute, second) - offsetInMs
    );
  }

  static setDateFormat(time) {
    var date;
    if (typeof time == "object") date = time;
    else date = this.parseDate(time);

    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    var hours = date.getHours();
    if (hours < 10) {
      hours = "0" + hours;
    }
    var minutes = date.getMinutes();
    if (minutes < 10) {
      minutes = "0" + minutes;
    }
    var newDate =
      (day.toString().length == 1 ? "0" + day : day) +
      "." +
      (month.toString().length == 1 ? "0" + month : month) +
      "." +
      year +
      " " +
      hours +
      ":" +
      minutes;
    return newDate;
  }

  static parseDate(date) {
    var year = date.substring(0, 4);
    var month = date.substring(5, 7) - 1;
    var day = date.substring(8, 10);
    var hour = date.substring(11, 13);
    var minute = date.substring(14, 16);
    var second = date.substring(17, 19);
    var offset = date.substring(20, 25);
    var offsetInHours = parseInt(offset) / 100;
    var offsetInMs = offsetInHours * 1000 * 60 * 60;
    return new Date(
      Date.UTC(year, month, day, hour, minute, second) - offsetInMs
    );
  }

  static setCurrentTimeHoursMinuteAsString() {
    //return  hours + ":" + minutes;
    var date = new Date();
    return this.setTimeHoursMinuteAsString(date);
  }

  static setTimeHoursMinuteAsString(date) {
    //return  hours + ":" + minutes;
    var hours = this.addZeroBehind10(date.getHours());
    var minutes = this.addZeroBehind10(date.getMinutes());
    var time = hours + ":" + minutes;
    return time;
  }

  static convDay2Date(days) {
    var kabisyear = false;
    var year = parseInt(days / 365.25);
    days -= parseInt(days / 1461); //(4 * 365 ) + 1 = 1461
    days -= year * 365;
    year += 1;
    if (year % 4 === 0 && days > 59) {
      kabisyear = true;
    }
    var month = 0;
    if (kabisyear) {
      if (days <= 31) month = 1;
      else if (days <= 60) {
        month = 2;
        days -= 31;
      } else if (days <= 91) {
        month = 3;
        days -= 60;
      } else if (days <= 121) {
        month = 4;
        days -= 91;
      } else if (days <= 152) {
        month = 5;
        days -= 121;
      } else if (days <= 182) {
        month = 6;
        days -= 152;
      } else if (days <= 213) {
        month = 7;
        days -= 182;
      } else if (days <= 244) {
        month = 8;
        days -= 213;
      } else if (days <= 274) {
        month = 9;
        days -= 244;
      } else if (days <= 305) {
        month = 10;
        days -= 274;
      } else if (days <= 335) {
        month = 11;
        days -= 305;
      } else if (days <= 366) {
        month = 12;
        days -= 335;
      }
    } else {
      if (days <= 31) month = 1;
      else if (days <= 59) {
        month = 2;
        days -= 31;
      } else if (days <= 90) {
        month = 3;
        days -= 59;
      } else if (days <= 120) {
        month = 4;
        days -= 90;
      } else if (days <= 151) {
        month = 5;
        days -= 120;
      } else if (days <= 181) {
        month = 6;
        days -= 151;
      } else if (days <= 212) {
        month = 7;
        days -= 181;
      } else if (days <= 243) {
        month = 8;
        days -= 212;
      } else if (days <= 273) {
        month = 9;
        days -= 243;
      } else if (days <= 304) {
        month = 10;
        days -= 273;
      } else if (days <= 334) {
        month = 11;
        days -= 304;
      } else if (days <= 365) {
        month = 12;
        days -= 334;
      }
    }

    days = this.addZeroBehind10(days);
    month = this.addZeroBehind10(month);
    return year + "-" + month + "-" + days;
  }

  static countOfDaysInMonth(date) { //data 2020-01-01
    let standardDateformat = new Date(date);
    let tempDate = this.setDateYearMonthDayAsString(standardDateformat);
    let year = tempDate.substr(0, 4);
    let month = tempDate.substr(5, 2);
    return this.countOfMonth(parseInt(year), parseInt(month));

  }

  static countOfMonth(year, month) {
    var temp = 0;
    if (month > 0 && month < 13) {
      switch (month) {
        case 1:
          temp = 31;
          break;
        case 2:
          if (year % 4 === 0) temp = 29;
          else temp = 28;
          break;
        case 3:
          temp = 31;
          break;
        case 4:
          temp = 30;
          break;
        case 5:
          temp = 31;
          break;
        case 6:
          temp = 30;
          break;
        case 7:
          temp = 31;
          break;
        case 8:
          temp = 31;
          break;
        case 9:
          temp = 30;
          break;
        case 10:
          temp = 31;
          break;
        case 11:
          temp = 30;
          break;
        case 12:
          temp = 31;
          break;
      }
    }
    return temp;
  }

  static addDays2Date(date, countday) {
    if (!date) return null;

    const [year, month, day] = date.split("-");
    var days = this.convDate2Day(
      parseInt(year),
      parseInt(month),
      parseInt(day)
    );
    days += countday;
    return this.convDay2Date(days);
  }

  static addMonth2Date(date, countMonth) {
    if (!date) return null;

    const [year, month, day] = date.split("-");
    var days = this.convDate2Day(
      parseInt(year),
      parseInt(month),
      parseInt(day)
    );
    var plusDay = 0;
    if (countMonth > 0) {
      plusDay = this.countOfMonth(parseInt(year), parseInt(month));
    } else {
      if (parseInt(month) === 1) {
        plusDay = this.countOfMonth(parseInt(year) - 1, 12);
      } else {
        plusDay = this.countOfMonth(parseInt(year), parseInt(month) - 1);
      }
      plusDay *= -1;
    }
    days += plusDay;
    return this.convDay2Date(days);
  }

  static formatDate(date) {
    if (!date) return null;

    const [year, month, day] = date.split("-");
    if (typeof day === "undefined") {
      return month + "." + year;
    } else {
      return day + "." + month + "." + year;
    }
  }

  static isNumberKey(evt) {
    evt = evt ? evt : window.event;
    var charCode = evt.which ? evt.which : evt.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 46);
  }

  static convTime2Minit2(hour, minit) {
    if (isNaN(hour)) hour = 0;
    if (isNaN(minit)) minit = 0;
    return hour * 60 + minit;
  }

  static convTime2Minit(time) {
    if (time == null) time = "00:00";
    var res = time.split(":");
    var allMinit = this.convTime2Minit2(parseInt(res[0]), parseInt(res[1]));
    return allMinit;
  }

  // static changeAnimationClass(oldclass, newclass, id, callback) {
  //   $("#" + id)
  //     .removeClass(oldclass)
  //     .addClass(newclass);
  //   $("#" + id).on("animationend", function() {
  //     callback();
  //   });
  // }
  static convMinit2Time(minit) {
    if (minit < 0) {
      minit *= -1;
      minit = minit % 1440; //24 * 60 = 1440
      minit = 1440 - minit;
    }
    var h = parseInt(minit / 60);
    var m = minit - h * 60;
    h = this.addZeroBehind10(h);
    m = this.addZeroBehind10(m);
    return h + ":" + m;
  }

  static addMinit2Time(time, minit, limitTimeMin, limitTimeMax) {
    var allMinit = this.convTime2Minit(time);
    var Lmin = this.convTime2Minit(limitTimeMin);
    var Lmax = this.convTime2Minit(limitTimeMax);
    if (isNaN(allMinit)) allMinit = 0;
    else allMinit += minit;

    if (Lmax != 0 && Lmax - Lmin >= 0) {
      if (allMinit >= Lmin && allMinit <= Lmax)
        return this.convMinit2Time(allMinit);
      else {
        if (allMinit < Lmin) {
          allMinit = Lmin;
          return this.convMinit2Time(allMinit);
        } else if (allMinit > Lmax) {
          allMinit = Lmax;
          return this.convMinit2Time(allMinit);
        }
      }
    } else if (Lmin > 0 && allMinit < Lmin) {
      allMinit = Lmin;
      return this.convMinit2Time(allMinit);
    } else {
      return this.convMinit2Time(allMinit);
    }
  }

  static difBtwTimes(time1, time2) {
    //differenceBetweenTimes
    var allMinit1 = this.convTime2Minit(time1);
    var allMinit2 = this.convTime2Minit(time2);
    if (allMinit1 <= allMinit2) {
      return this.convMinit2Time(allMinit2 - allMinit1);
    } else {
      return this.convMinit2Time(allMinit1 - allMinit2);
    }
  }

  static add2Times(time1, time2) {
    var allMinit1 = this.convTime2Minit(time1);
    var allMinit2 = this.convTime2Minit(time2);

    return this.convMinit2Time(allMinit2 + allMinit1);
  }

  // static countSumme(index) {
  //   var endTime = "24:00";
  //   if (this.timeStampsMonth[index].datum == this.justNow) {
  //     var ttt = new Date().toISOString();
  //     endTime = this.timeFromServer;
  //   }
  //   var kommen = this.timeStampsMonth[index].ankommen.split(";");
  //   var gehen = this.timeStampsMonth[index].gehen.split(";");
  //   var pauseS = this.timeStampsMonth[index].pauseStart.split(";");
  //   var pauseE = this.timeStampsMonth[index].pauseEnd.split(";");
  //   kommen.pop();
  //   gehen.pop();
  //   var gesamtworktime = "";
  //   var gesamtKommen = "";
  //   var gesamtgehen = "";
  //   if (
  //     kommen.length - gehen.length <= 1 &&
  //     kommen.length - gehen.length >= -1
  //   ) {
  //     for (i = 0; i < kommen.length; i++) {
  //       tmpk = this.difBtwTimes(kommen[i], endTime);
  //       gesamtKommen = this.add2Times(gesamtKommen, tmpk);
  //     }
  //     for (i = 0; i < gehen.length; i++) {
  //       tmpk = this.difBtwTimes(gehen[i], endTime);
  //       gesamtgehen = this.add2Times(gesamtgehen, tmpk);
  //     }
  //     gesamtworktime = this.difBtwTimes(gesamtKommen, gesamtgehen);
  //     if (convTime2Minit(gesamtKommen) < convTime2Minit(gesamtgehen)) {
  //       gesamtworktime = this.difBtwTimes(gesamtworktime, endTime);
  //     }
  //   } else {
  //     return "";
  //   }
  //   pauseS.pop();
  //   pauseE.pop();
  //   var gesamtpauseS = "";
  //   var gesamtpauseE = "";
  //   var gesamtpause = "";
  //   if (
  //     pauseS.length - pauseE.length <= 1 &&
  //     pauseS.length - pauseE.length >= -1
  //   ) {
  //     for (i = 0; i < pauseS.length; i++) {
  //       tmpk = this.difBtwTimes(pauseS[i], endTime);
  //       gesamtpauseS = this.add2Times(gesamtpauseS, tmpk);
  //     }
  //     for (i = 0; i < pauseE.length; i++) {
  //       tmpk = this.difBtwTimes(pauseE[i], endTime);
  //       gesamtpauseE = this.add2Times(gesamtpauseE, tmpk);
  //     }
  //     gesamtpause = this.difBtwTimes(gesamtpauseS, gesamtpauseE);
  //     if (
  //       this.convTime2Minit(gesamtpauseS) < this.convTime2Minit(gesamtpauseE)
  //     ) {
  //       gesamtpause = this.difBtwTimes(gesamtpause, endTime);
  //     }
  //   } else {
  //     return "";
  //   }
  //
  //   return this.difBtwTimes(gesamtworktime, gesamtpause);
  // }
}
