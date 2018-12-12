<script type="text/javascript">
    function get_years() {
        var year = "{{ isset($user) ? $user->year : '' }}";
        var currentYear = new Date().getFullYear(), years = [];
        var startYear = 1960;

        years += '<option value="">Select Year</option>';
        if(year) {
            years += '<option value="{{ isset($user)? $user->year : '' }}" selected>{{ isset($user)? $user->year : '' }}</option>';
        }
        while ( startYear <= currentYear ) {
            years += '<option value="' + startYear +'">' + startYear + '</option>';
            startYear++;
        }

        $('#year').html(years);
    }

    function get_countries() {
        var country = [];
        country += '<option value="">Select Country</option>';
        var currentCountry = "{{ isset($user) ? $user->country : '' }}";
        if(currentCountry)
            country += '<option value="{{ isset($user)? $user->country : '' }}" selected>{{ isset($user)? $user->country : '' }}</option>';

        var country_list = ["Australia","Brazil","China","France","Germany","Italy","India","South Korea","Spain","Singapore","Indonesia","Canada","United States","United Kingdom","Afghanistan"
            ,"Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Austria","Azerbaijan","Bahamas"
            ,"Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","British Virgin Islands"
            ,"Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","Colombia","Congo","Cook Islands","Costa Rica"
            ,"Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea"
            ,"Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Ghana"
            ,"Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland"
            ,"Iran","Iraq","Ireland","Isle of Man","Israel","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia"
            ,"Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania"
            ,"Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia"
            ,"New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal"
            ,"Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles"
            ,"Sierra Leone","Slovakia","Slovenia","South Africa","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan"
            ,"Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia"
            ,"Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United Arab Emirates","United States Minor Outlying Islands","Uruguay"
            ,"Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

        country_list.map(function(item){
            country += '<option value="' + item + '">' + item + '</option>';
            if(item == "United Kingdom") {
                country += '<option value="" disabled="disabled">─────────────────────────────────────────</option>';
            }
        });

        $('#country').html(country);
    }
</script>