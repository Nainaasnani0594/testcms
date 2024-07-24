<template>
    <div>
      <div id="piechart" style="width: 100%; height: 500px;"></div>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue';
  
  // Dummy data for the pie chart
  const dummyData = [
    { project_name: 'Project Name', contract_value: 7 },
    { project_name: 'Contract Value', contract_value: 7 },
    { project_name: 'Work Done', contract_value: 5 },
    { project_name: 'Country', contract_value: 5 },
    { project_name: 'Phase', contract_value: 7 },
    { project_name: 'Status', contract_value: 7 }

  ];
  
  // Function to load Google Charts and draw the chart
  function loadGoogleCharts() {
    const script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://www.gstatic.com/charts/loader.js';
    script.onload = () => {
      google.charts.load('current', { packages: ['corechart'] });
      google.charts.setOnLoadCallback(drawChart);
    };
    document.head.appendChild(script);
  }
  
  // Function to draw the chart
  function drawChart() {
    // Transform data for Google Charts
    const data = google.visualization.arrayToDataTable([
      ['Project', 'Contract Value'],
      ...dummyData.map(item => [item.project_name, item.contract_value])
    ]);
  
    const options = {
      title: 'My Project Details',
      pieSliceText: 'label',
      legend: { position: 'top', alignment: 'center' },
    };
  
    const chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
  }
  
  onMounted(() => {
    loadGoogleCharts();
  });
  </script>
  
  <style scoped>
  /* Add any styles if needed */
  </style>
  