export default {
  // General
  language_picker_helper: "Language",
  shortCode: "GB",
  langCode: "en-EN",
  logoName: "diwan marburg Akademie GmbH",

  reset: "reset",
  save: "save",
  continue: "continue",
  back: "back",
  address: "address",
  cancel: "Cancel",
  ok: "Ok",
  actions: "Actions",
  row: "row",

  // TelRegisterForm
  TelcMember: {
    TelcMember: "Telc Member",
    telcExam: "Telc Exam Register",
    personalData: "personal data",
    archiveNumber: "Archive number",
    sheetNumber: "Sheet number",
    memberNr: "Member Nr.",
    male: "Male",
    female: "Female",
    gender: "gender",
    firstName: "First Name",
    lastName: "Last Name",
    email: "Email",
    title: "Title",
    mobile: "Mobile",
    birthCountry: "country of birth",
    birthCity: "city of birth",
    streetNr: "Street, house number",
    co: "C/O",
    postCode: "post code",
    place: "place",
    country: "country",
    exam: "exam",
    nativeLanguage: "Native Language",
    orally: "speaking",
    written: "Writting",
    warningDialogtext: 'Registration completed successfully',
    warningDialogUpdate: "update completed successfully",
    warningDialogtextErorr: "There was a problem registering you. Please try again.",
    others: "Others",
    accommodationRequest: "If you would like accommodation, please select",
    newsletterSubscribe: "Would you like to subscribe to our newsletter for free?",
    description: "Your message to us",
    birthday: "Birthday",
    AGB: "terms and conditions",
    AGB1: "I have read the ",
    AGB2: "and accept them.",
    privacyPolicy: "Privacy Policy",
    privacyPolicy1: "I have read the ",
    privacyPolicy2: " and accept them.",
    register: "register",
    reset: "reset",
    partExam: "Your desired part of the exam",
    examType: "Exam type",
    examDate: "Exam date",
    lastMemberNr: "last Member number",
    job: "job",
    examInfo: "exam info:",
    examDateInfo: "exam Date info:",
    dateWritingExam: "date of writing exam",
    dateSpeakingExam: "date of speaking exam",
    dateRegistrationDeadlineExam: "date of registration deadline",
    dateLastRegistrationDeadline: "Date of the last registration deadline",
    remarks: "remarks",
    passed: "passed",
    grades: "grades",
    registerDate:"register Date",
    registerTime:"register Time",
    alertMessage1: "Please fill in all fields",

    rules: {
      genderRules: "Selection is required",
      firstNameRules1: "First name is required",
      firstNameRules2: "The first name must not be longer than 50 characters",
      lastNameRules1: "Last name is required",
      lastNameRules2: "The last name cannot be longer than 50 characters",
      EmailRules1: "Email is required",
      EmailRules2: "Email must be valid",
      BirthdayRules: "Birthday is required",
      mobileRules1: "Mobile is required",
      mobileRules2: "The number cannot be longer than 20 characters",
      mobileRules3: "number must be valid",
      streetNrRules1: "Street and number is required",
      streetNrRules2: "The street and number must not be longer than 70 characters",
      streetNrRules3: "The street and number must be valid, e.g.(frankfurter Str. 99)",
      postCodeRules1: "ZIP is required",
      postCodeRules2:"ZIP code cannot be longer than 10 characters",
      placeRules1: "Location is required",
      placeRules2: "Place cannot be longer than 50 characters",
      countryRules1: "country is required",
      countryRules2: "Country cannot be longer than 50 characters",
      examDateRules1: "Exam date is required",
      examDateRules2: "Exam date cannot be longer than 10 characters",
      nativeLanguageRules:"native language is required",
      examTypeRules: "Exam designation is required",
      lastMemberNrRules1: "last membership Number is necessary",
      lastMemberNrRules2: "The last membership number cannot be longer than 50 characters",
      partExamRules: "Selection is required",
      checkboxAGB_Rules: "Consent is required",
      checkboxDSE_Rules: "Consent is required",
    }
  },

  ExamType: {
    ExamType: "exam type",
    id: "id",
    examType: "Exam type",
    language: "language",
    type: "type",
    subtype: "subtype",
    description: "description",
    rules: {
      languageRules:"language is required",
      typeRules1: "type is required",
      typeRules2: "The type cannot be longer than 50 characters",
      subtypeRules1: "subtype is required",
      subtypeRules2: "The subtype cannot be longer than 50 characters",
    }
  },

  ExamDate: {
    ExamDate: "exam date",
    id: "Reihe",
    writingExamDate: "writing Exam Date",
    speakingExamData: "speaking Exam Data",
    registrationDeadline: "registration Deadline",
    lastRegistrationDeadline: "last Registration Deadline",
    examTypes: "Exam type",
    rules:{
      examTypesRules1:"exam type is required",
    }
  },

  captcha: {
    captchaText: "Please enter the Code",
  },

  MyDataTable: {
    warningDeleteText:"Are you sure you want to delete this item?",
    newItem: "Add New Item",
    editItem: "Edit",
    deleteItem: "Delete",
    exportToExcel: "export To Excel",
    clearFilter: "Clear Filter",
  },

  datePicker :{
    date: "date (DD.MM.YYYY)",
    hint: "(DD.MM.YYYY)",
    rules: {
      date1: "date is required (DD.MM.YYYY)",
      date2: "date  must be valid (DD.MM.YYYY)",
    }
  },

  store:{
    examDate:{
      writingExamDate: "writing ExamDate",
    }
  },

  Users:{
    id: "id",
    Users: "Users",
    firstName: "first name",
    lastName: "last name",
    user: "User",
    password: "password",
    access: "access",
    login:"login",

    rules:{
      firstNameRules1: "First name is required",
      firstNameRules2: "The first name must not be longer than 50 characters",
      lastNameRules1: "Last name is required",
      lastNameRules2: "The last name cannot be longer than 50 characters",
      userRules1: "User is required",
      userRules2: "User must be valid",
      passwordRules1: "password is required",
      passwordRules2: "password must be valid",
    }
  },

  Login:{
    id: "id",
    Users: "Users",
    firstName: "first name",
    lastName: "last name",
    user: "User",
    password: "password",
    access: "access",
    login:"login",
    Login:"login",
    forgotPassword:"Forgot Password",

    rules:{
      firstNameRules1: "First name is required",
      firstNameRules2: "The first name must not be longer than 50 characters",
      lastNameRules1: "Last name is required",
      lastNameRules2: "The last name cannot be longer than 50 characters",
      userRules1: "User is required",
      userRules2: "User must be valid",
      passwordRules1: "password is required",
      passwordRules2: "password must be valid",
    }
  },

  MySelectAll: {
    selectAll: "select all",
    itemsCount: "Items Count",
    others: "others",
    rules:{
      allSelectRules: "selection is required",
    }
  },

  Menu: {
    menu: "MENU",
  },

  Session:{
    Session: "Session",
    id: "row",
    session: "session",
    date: "date",

  }

};
