<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tele Country Select</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</head>
<body>
    <div>
        <form>
            <label for="countrySelect">Country: </label>
            <select name="country" id="country">
                <option value="">Select Country</option>
            </select>
            <br><br>
            <label for="phone">Phone: </label>
            <input type="text" name="phone" id="phone">
            <input type="hidden" name="real_phone" id="real_phone">
        </form>
    </div>

    <script>
        $("select option:first-child").attr("disabled", "true");

        const countryData = window.intlTelInputGlobals.getCountryData();
        const input = document.querySelector("#phone");
        const addressDropdown = document.querySelector("#country");
        const iti = window.intlTelInput(input, {
            initialCountry: "ae",
            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // just for formatting/placeholders etc
        });

        $('#phone').on('change', function(e) {
            process(e);
        });

        function process(event) {
            event.preventDefault();
            const phoneNumber = iti.getNumber(); console.log(phoneNumber)
            $('#real_phone').val(`${phoneNumber}`);
        }

        // populate the country dropdown
        for (let i = 0; i < countryData.length; i++) {
        const country = countryData[i];
        const optionNode = document.createElement("option");
        optionNode.value = country.name;
        optionNode.setAttribute('countrycode', country.iso2);
        // optionNode.innerHTML = country.iso2;
        const textNode = document.createTextNode(country.name);
        optionNode.appendChild(textNode);
        addressDropdown.appendChild(optionNode);
        }

        // set it's initial value
        addressDropdown.value = iti.getSelectedCountryData().name;

        // listen to the telephone input for changes
        input.addEventListener('countrychange', () => {
        addressDropdown.value = iti.getSelectedCountryData().name;
        });

        addressDropdown.addEventListener('change', function() {
            var option = $('option:selected', this).attr('countrycode');
            iti.setCountry(option);
        });
    </script>
</body>
</html>