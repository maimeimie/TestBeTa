const savedData = [];

function handleCheckboxChange() {
    const alcoholCheckbox = document.getElementById('alcohol');
    const smokingCheckbox = document.getElementById('smoking');
    const noRiskCheckbox = document.getElementById('no_risk');
}
function handleTemperatureChange() {
    const temp1 = document.getElementById('temp1');
    const temp2 = document.getElementById('temp2');
    const temp3 = document.getElementById('temp3');
    const temp4 = document.getElementById('temp4');
    const temperatureDurationOptions = document.getElementById('temperature-duration');
    const labels = document.querySelectorAll('.checkbox-label');

    // Reset colors of all labels
    labels.forEach(label => {
        label.className = 'checkbox-label'; // Reset to default class name
    });

    // Show duration options if specific temperatures are selected
    if (temp2.checked || temp3.checked || temp4.checked) {
        temperatureDurationOptions.style.display = 'block'; // Show temperature duration options
    } else {
        temperatureDurationOptions.style.display = 'none'; // Hide temperature duration options
    }

    // Change label colors based on selection
    if (temp1.checked) {
        document.querySelector('label[for="temp1"]').classList.add('temp-green');
    } else if (temp2.checked) {
        document.querySelector('label[for="temp2"]').classList.add('temp-yellow');
    } else if (temp3.checked) {
        document.querySelector('label[for="temp3"]').classList.add('temp-orange');
    } else if (temp4.checked) {
        document.querySelector('label[for="temp4"]').classList.add('temp-red');
    }
}

function toggleSlider(id) {
    const slider = document.getElementById(`slider-${id}`);
    const valueLabel = document.getElementById(`value-${id}`);
    const checkbox = document.getElementById(id);

    if (checkbox.checked) {
        slider.style.display = 'block';
        valueLabel.style.display = 'inline';
        updateSlider(slider.id, valueLabel.id);
    } else {
        slider.style.display = 'none';
        valueLabel.style.display = 'none';
    }
}

function updateSlider(sliderId, valueId) {
    const slider = document.getElementById(sliderId);
    const valueLabel = document.getElementById(valueId);
    const value = slider.value;

    let levelText = '';
    if (value >= 0 && value <= 2) {
        levelText = 'เล็กน้อย';
        slider.style.background = 'lightgreen';
    } else if (value >= 3 && value <= 5) {
        levelText = 'ปานกลาง';
        slider.style.background = 'yellow';
    } else if (value >= 6 && value <= 8) {
        levelText = 'สูง';
        slider.style.background = 'orange';
    } else if (value >= 9 && value <= 10) {
        levelText = 'รุนแรงมาก';
        slider.style.background = 'red';
    }

    valueLabel.textContent = `ระดับ: ${levelText} ${value}`;
}

function saveData() { 
    const data = [];
    const currentTime = new Date().toLocaleString();

    // เก็บข้อมูลอาการ
    const symptomCheckboxes = document.querySelectorAll('input[name="symptom"]:checked');
    symptomCheckboxes.forEach(checkbox => {
        const symptomName = checkbox.value;
        const severitySlider = document.querySelector(`#slider-${checkbox.id}`);
        if (severitySlider) {
            const severityLevel = severitySlider.value;
            const colorValue = getColorValue(severityLevel);
            data.push({ time: currentTime, symptom: symptomName, severity: severityLevel, color: colorValue });
        }
    });

    // เก็บข้อมูลอุณหภูมิ
const temperature = document.querySelector('input[name="temperature"]:checked');
let tempValue = temperature ? temperature.value : 'ไม่มีการเลือก';
let tempDuration = '';

if (temperature && (temperature.id === 'temp2' || temperature.id === 'temp3' || temperature.id === 'temp4')) {
const temperatureDurationSelect = document.querySelector('#temperature-duration select');
if (temperatureDurationSelect) {
tempDuration = temperatureDurationSelect.options[temperatureDurationSelect.selectedIndex].text;
}
}

    // เก็บข้อมูลโรคประจำตัว
    const chronicDiseases = [];
    const diseaseCheckboxes = document.querySelectorAll('input[name="disease"]:checked');
    diseaseCheckboxes.forEach(checkbox => {
        chronicDiseases.push(checkbox.value);
    });

    // เก็บข้อมูลความเสี่ยง
    const risks = [];
    const riskCheckboxes = document.querySelectorAll('input[name="risk"]:checked');
    riskCheckboxes.forEach(checkbox => {
        risks.push(checkbox.value);
    });

    let riskDuration = '';
    if (riskCheckboxes.length > 0) {
        const durationOptions = document.getElementById('risk-duration-options');
        if (durationOptions && durationOptions.style.display !== 'none') {
            const riskDurationSelect = document.getElementById('risk-duration-select');
            if (riskDurationSelect) {
                riskDuration = riskDurationSelect.options[riskDurationSelect.selectedIndex].text;
            }
        }
    }

    // บันทึกข้อมูลลง localStorage
    localStorage.setItem('symptomData', JSON.stringify(data));
    localStorage.setItem('temperature', tempValue);
    localStorage.setItem('temperature_duration', tempDuration);
    localStorage.setItem('chronicDiseases', JSON.stringify(chronicDiseases));
    localStorage.setItem('risks', JSON.stringify(risks));

    // เปลี่ยนหน้าไปยัง History.html
    window.location.href = 'ปริ้นต์.html';
}

function getColorValue(severityLevel) {
    if (severityLevel <= 2) return 'green';
    else if (severityLevel <= 5) return 'yellow';
    else if (severityLevel <= 8) return 'orange';
    else return 'red';
}