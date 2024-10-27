window.onload = function() {
    const fullName = localStorage.getItem('fullName');
    const age = localStorage.getItem('age');
    const idNumber = localStorage.getItem('idNumber');
    const symptomData = JSON.parse(localStorage.getItem('symptomData')) || [];
    const temperature = localStorage.getItem('temperature');
    const tempDuration = localStorage.getItem('temperature_duration');
    const chronicDiseases = JSON.parse(localStorage.getItem('chronicDiseases')) || [];
    const risks = JSON.parse(localStorage.getItem('risks')) || [];
    const riskDuration = localStorage.getItem('risk_duration');

    document.getElementById('fullName').textContent = fullName || '';
    document.getElementById('age').textContent = age || '';
    document.getElementById('idNumber').textContent = idNumber || '';

    const symptomsBody = document.getElementById('symptoms-body');
    symptomData.forEach(item => {
        const [date, time] = item.time.split(' ');
        const severityLevelText = getSeverityLevelText(item.severity);
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${date}</td>
            <td>${time}</td>
            <td>${item.symptom}</td>
            <td>${severityLevelText} (${item.severity})</td>
            <td style="background-color: ${item.color}">${item.color}</td>
        `;
        symptomsBody.appendChild(row);
    });

    document.getElementById('temperature-info').textContent = tempDuration ? `${temperature} (${tempDuration})` : temperature;
    document.getElementById('chronic-diseases-info').textContent = chronicDiseases.length > 0 ? chronicDiseases.join(', ') : 'ไม่มี';
    document.getElementById('risks-info').textContent = riskDuration ? `${risks.join(', ')} (${riskDuration})` : (risks.length > 0 ? risks.join(', ') : 'ไม่มี');
}

function printForm() {
    window.print();
    showCountdownPopup();
}

function showCountdownPopup() {
    const popupContainer = document.createElement('div');
    popupContainer.className = 'popup-container';
    const popup = document.createElement('div');
    popup.className = 'popup';
    popupContainer.appendChild(popup);
    document.body.appendChild(popupContainer);

    let countdown = 30;
    const countdownInterval = setInterval(() => {
        popup.innerHTML = `<h3>กำลังกลับไปหน้าแรกใน ${countdown} วินาที</h3>`;
        countdown--;
        if (countdown < 0) {
            clearInterval(countdownInterval);
            document.body.removeChild(popupContainer);
            window.location.href = 'Home.html';
        }
    }, 1000);
}

function getSeverityLevelText(severity) {
    if (severity >= 0 && severity <= 2) {
        return 'ระดับเล็กน้อย';
    } else if (severity >= 3 && severity <= 5) {
        return 'ระดับปานกลาง';
    } else if (severity >= 6 && severity <= 8) {
        return 'ระดับสูง';
    } else if (severity >= 9 && severity <= 10) {
        return 'ระดับรุนแรงมาก';
    }
    return '';
}