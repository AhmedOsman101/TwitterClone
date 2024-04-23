const ValidateRegister = (form) => {
    for (const field of form) {
        if (field.empty()) return false;
    }

    const full_nameRegEx = /^[A-z0-9_]{3,18}$/;
    const passwordRegEx =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_])[A-Za-z\d$@$!%*?&_]{8,20}$/;
    const emailRegEx = /[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}/gim;

    if (!emailRegEx.match(form.email)) return false;
    if (!passwordRegEx.match(form.password)) return false;
    if (!full_nameRegEx.match(form.full_name)) return false;
    if (!full_nameRegEx.match(form.username)) return false;
};
