const makeUA = function () {
  console.log('makeUA() works!');
  const elements = document.getElementsByTagName('INPUT');
  for (i = 0; i < elements.length; i++) {
    const inpEl = elements[i];
    const elType = elements[i].getAttribute('TYPE');
    if (elType === 'email') {
      inpEl.removeAttribute('type');
      inpEl.setAttribute('type', 'text');
      inpEl.setAttribute('minlength', '6');
      inpEl.setAttribute('maxlength', '255');
      console.log('Input element type changed to text');
      console.log(inpEl);
      inpEl.addEventListener('change', function (e) {
        e.preventDefault();
        const inpEmail = this.value;
        doFormatValidation(inpEmail);
      });
    } else if (elType === 'text') {
      const elId = elements[i].getAttribute('ID');
      if (elId === 'emailua') {
        inpEl.setAttribute('minlength', '6');
        inpEl.setAttribute('maxlength', '255');
        console.log(inpEl);
        inpEl.addEventListener('change', function (e) {
          e.preventDefault();
          const inpEmail = this.value;
          doFormatValidation(inpEmail);
        });
      }
    }
  }
};

// 1. Email Format Validation
const doFormatValidation = function (emailAddress) {
  const emailEl = document.getElementById('emailua');
  const regEx =
    /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  const pattern = new RegExp(regEx);
  if (pattern.test(emailAddress)) {
    const domainArr = emailAddress.split('@');
    const domainPart = domainArr[1];
    console.log(domainPart);
    doDomainValidation(domainPart);
  } else {
    alert('❌ Incorrect email format.');
    emailEl.value = "";
  }
};

// 2. Domain Part Validation
const doDomainValidation = async function (domainPart) {
  console.log('Domain Part :', domainPart);
  const apiUrl =
    'https://cartrefs.com/php_ua/makeUA.php?function=i2a&input=' +
    encodeURIComponent(domainPart);
  const idnObj = await makeCall(apiUrl);
  const result = idnObj['result'];
  const emailEl = document.getElementById('emailua');
  if (result === '1') {
    const idnStatus = idnObj['status'];
    doTLDValidation(domainPart, idnStatus);
  } else if (result === '0') {

    alert(idnObj['status']);
    emailEl.value = "";
  }
};

// 3.a Top Level Domain (TLD) Validation - Back End
const doTLDValidation = async function (domainPart, idnStatus) {
  console.log('Domain Part :', domainPart);
  const apiUrl =
    'https://cartrefs.com/php_ua/makeUA.php?function=check_TLD&input=' +
    encodeURIComponent(domainPart);
  const tldObj = await makeCall(apiUrl);
  const tldStatus = tldObj['status'];
  const result = tldObj['result'];
  const formatStatus = '✔️ Correct email format. ';
  const emailEl = document.getElementById('emailua');
  if (result === '1') {
    alert(
      'Valid email address. \n' +
        formatStatus +
        '\n' +
        idnStatus +
        '\n' +
        tldStatus
    );
  } else if (result === '0') {
    alert(tldStatus);
    emailEl.value = "";
  }
};

// General Purpose Function
const makeCall = function (apiUrl) {
  return new Promise((resolve, reject) => {
    fetch(apiUrl)
      .then(res => res.json())
      .then(data => resolve(data))
      .catch(err => reject(err));
  });
};

window.addEventListener('load', makeUA);