const companySymbolEl = document.querySelector('#companySymbol');
const startDateEl = document.querySelector('#startDate');
const endDateEl = document.querySelector('#endDate');
const emailEl = document.querySelector('#email');

const form = document.querySelector('#frmCompanyData');

$( function() {

    $( "#startDate" ).datepicker({
        dateFormat: "yy-mm-dd",
        maxDate: new Date() ,
        onSelect: function(dateText) {
           checkStartDate();
          }
      });
      
    $( "#endDate" ).datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(dateText) {
            checkEndDate();
          }
      });
  
} );


const checkCompanySymbol = () => {

    let valid = false;
    const min = 1,
        max = 5;
    const companysymbol = companySymbolEl.value.trim();

    if (!isRequired(companysymbol)) {
        showError(companySymbolEl, 'Company Symbol cannot be blank.');
    } else if (!isBetween(companysymbol.length, min, max)) {
        showError(companySymbolEl, `Company Symbol be between ${min} and ${max} characters.`)
    }
    else if (!isValid(companysymbol)) {
        showError(companySymbolEl, `company symbol is not valid, only letters with capital case.`)
    } 
    else {
        showSuccess(companySymbolEl);
        valid = true;
    }
    return valid;
};


const checkEmail = () => {
    let valid = false;
    const email = emailEl.value.trim();
    if (!isRequired(email)) {
        showError(emailEl, 'Email cannot be blank.');
    } else if (!isEmailValid(email)) {
        showError(emailEl, 'Email is not valid.')
    } else {
        showSuccess(emailEl);
        valid = true;
    }
    return valid;
};

const checkStartDate= () => {
    let valid = false;
    const startdate = startDateEl.value.trim();
    const enddate = endDateEl.value.trim();

    if (!isRequired(startdate)) {
        showError(startDateEl, 'Start date cannot be blank.');
    } else if (!isDateValid(startdate)) {
        showError(startDateEl, 'The date should be valid');
    } 
    else if (!isValidStartDate(startdate,enddate)) {
        showError(startDateEl, 'The date should be less than or equal current date and less than end date.');
    }
    else {
        showSuccess(startDateEl);
        valid = true;
    }

    return valid;
};

const checkEndDate= () => {

    let valid = false;
    const startdate = startDateEl.value.trim();
    const enddate = endDateEl.value.trim();

    if (!isRequired(enddate)) {
        showError(endDateEl, 'end date cannot be blank.');
    } else if (!isDateValid(enddate)) {
        showError(endDateEl, 'The date should be valid');
    } 
    else if (!isValidEndDate(startdate,enddate)) {
        showError(endDateEl, 'The date should be less than or equal current date and greater than start date.');
    }
    else {
        showSuccess(endDateEl);
        valid = true;
    }

    return valid;
};



const isEmailValid = (email) => {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};

const isValid = (companysymbol) => {
    const re = /^[A-Z]+$/;
    return re.test(companysymbol);
}

const isDateValid = (datestring) => {


    // First check for the pattern
    var regex_date = /^\d{4}\-\d{1,2}\-\d{1,2}$/;

    if(!regex_date.test(datestring))
    {
        return false;
    }

    // Parse the date parts to integers
    var parts   = datestring.split("-");
    var day     = parseInt(parts[2], 10);
    var month   = parseInt(parts[1], 10);
    var year    = parseInt(parts[0], 10);

    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
    {
        return false;
    }

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
    {
        monthLength[1] = 29;
    }

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
}

const isValidStartDate = (startdate,enddate) =>{
    let flag = true;
    var currentDate = new Date();
    if(enddate.length > 0 ){
        if(startdate > enddate){
            flag =  false;
        }
    }

    if (new Date(startdate).getTime() > currentDate.getTime()) {
        flag =  false;
    } 
    return flag;
}

const isValidEndDate = (startdate,enddate) =>{
    let flag = true;
    var currentDate = new Date();
    if(startdate !== null){
        if(enddate < startdate){
            flag = false;
        }
    }

    if (new Date(enddate).getTime() > currentDate.getTime()) {
        flag = false;
    } 
    return flag;
}




const isRequired = value => value === '' ? false : true;
const isBetween = (length, min, max) => length < min || length > max ? false : true;


const showError = (input, message) => {
    // get the form-field element
    const formField = input.parentElement;
    // add the error class
    formField.classList.remove('success');
    formField.classList.add('error');

    // show the error message
    const error = formField.querySelector('small');
    error.textContent = message;
};

const showSuccess = (input) => {
    // get the form-field element
    const formField = input.parentElement;

    // remove the error class
    formField.classList.remove('error');
    formField.classList.add('success');

    // hide the error message
    const error = formField.querySelector('small');
    error.textContent = '';
}


form.addEventListener('submit', function (e) {
    // prevent the form from submitting
    e.preventDefault();

    
    let isUsernameValid = checkCompanySymbol(),
        isEmailValid = checkEmail(),
        isStartDateValid = checkStartDate(),
        isEndDateValid = checkEndDate();

    let isFormValid = isUsernameValid && isEmailValid && isStartDateValid && isEndDateValid;

    //submit to the server if the form is valid
    if (isFormValid) {
        $("#preloder").fadeIn();
        $("#frmCompanyData").submit();
    }
});


const debounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
       
        timeoutId = setTimeout(() => {
            fn.apply(null, args)
        }, delay);
    };
};

form.addEventListener('input', debounce(function (e) {
    
    switch (e.target.id) {
        case 'companySymbol':
            checkCompanySymbol();
            break;
        case 'email':
            checkEmail();
            break;
        case 'startDate':
            checkStartDate();
            break;
        case 'endDate':
            checkEndDate();
            break;

    }
}));


