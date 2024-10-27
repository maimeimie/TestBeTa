window.onload = function() {
  const historyData = JSON.parse(localStorage.getItem('historyData')) || {};
  const historyContainer = document.getElementById('history-container');

  if (Object.keys(historyData).length === 0) {
      historyContainer.innerHTML = "<p>ไม่มีข้อมูลประวัติการประเมินอาการ</p>";
      return;
  }

  Object.keys(historyData).forEach(date => {
      const dateDiv = document.createElement('div');
      dateDiv.innerHTML = `<h2>${date}</h2>`;
      
      historyData[date].forEach(record => {
          const recordDiv = document.createElement('div');
          recordDiv.innerHTML = `
              <p><strong>เวลา:</strong> ${record.time}</p>
              <p><strong>อาการ:</strong> ${record.symptoms.map(s => `${s.symptom} (ระดับ: ${s.severity})`).join(', ')}</p>
              <p><strong>อุณหภูมิ:</strong> ${record.temperature} ${record.tempDuration ? `(${record.tempDuration})` : ''}</p>
              <p><strong>โรคประจำตัว:</strong> ${record.diseases.join(', ') || 'ไม่มี'}</p>
              <p><strong>ความเสี่ยง:</strong> ${record.risks.join(', ') || 'ไม่มี'}</p>
              <hr>
          `;
          dateDiv.appendChild(recordDiv);
      });

      historyContainer.appendChild(dateDiv);
  });
};
