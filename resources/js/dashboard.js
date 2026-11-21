/* ============================================================
   ESDM SATU DATA WILAYAH IV — Dashboard interactions
   Dimuat melalui Vite (@vite). Tanpa library animasi tambahan.
   ============================================================ */

function readJsonIsland(id) {
    const el = document.getElementById(id);
    if (!el) return null;

    try {
        return JSON.parse(el.textContent);
    } catch (error) {
        console.warn(`Dashboard: payload "${id}" tidak valid.`, error);
        return null;
    }
}

function escapeHtml(value) {
    const entities = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' };
    return String(value ?? '').replace(/[&<>"']/g, (character) => entities[character]);
}

/* ── Chart.js: Grafik Data per Kabupaten ──────────────────── */
function buildChart(canvas, chartData) {
    const chart = new Chart(canvas, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Usaha ESDM',
                    data: chartData.usaha,
                    backgroundColor: 'rgba(37, 99, 235, 0.85)',
                    hoverBackgroundColor: '#2563EB',
                    borderRadius: 6,
                    borderSkipped: false,
                    maxBarThickness: 42,
                },
                {
                    label: 'Mineral',
                    data: chartData.mineral,
                    backgroundColor: 'rgba(30, 64, 175, 0.78)',
                    hoverBackgroundColor: '#1E40AF',
                    borderRadius: 6,
                    borderSkipped: false,
                    maxBarThickness: 42,
                },
                {
                    label: 'Energi',
                    data: chartData.energi,
                    backgroundColor: 'rgba(8, 145, 178, 0.78)',
                    hoverBackgroundColor: '#0891B2',
                    borderRadius: 6,
                    borderSkipped: false,
                    maxBarThickness: 42,
                },
                {
                    label: 'Pengawasan',
                    data: chartData.pengawasan,
                    backgroundColor: 'rgba(100, 116, 139, 0.62)',
                    hoverBackgroundColor: '#64748B',
                    borderRadius: 6,
                    borderSkipped: false,
                    maxBarThickness: 42,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0F172A',
                    titleColor: '#F8FAFC',
                    bodyColor: '#CBD5E1',
                    cornerRadius: 10,
                    padding: 12,
                    boxPadding: 5,
                    displayColors: true,
                    usePointStyle: true,
                    titleFont: { family: 'Poppins', size: 12, weight: '600' },
                    bodyFont: { family: 'Poppins', size: 12 },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: '#64748B',
                        font: { family: 'Poppins', size: 11 },
                    },
                },
                y: {
                    beginAtZero: true,
                    border: { display: false },
                    grid: { color: 'rgba(226, 232, 240, 0.7)' },
                    ticks: {
                        color: '#94A3B8',
                        font: { family: 'Poppins', size: 11 },
                        precision: 0,
                    },
                },
            },
        },
    });

    return chart;
}

/* ── Toolbar chip: tampil/sembunyikan dataset grafik ──────── */
function initChartToolbar(chart) {
    const chips = document.querySelectorAll('.chart-chip[data-dataset]');
    if (!chips.length || !chart) return;

    chips.forEach((chip) => {
        chip.addEventListener('click', () => {
            const index = Number(chip.dataset.dataset);
            if (!Number.isInteger(index) || !chart.data.datasets[index]) return;

            const visible = !chart.isDatasetVisible(index);
            chart.setDatasetVisibility(index, visible);
            chip.classList.toggle('is-active', visible);
            chart.update();
        });
    });
}

function initChart() {
    const canvas = document.getElementById('chartKabupaten');
    const chartData = readJsonIsland('dashboard-chart-data');

    if (!canvas || !chartData || typeof Chart === 'undefined') return;

    initChartToolbar(buildChart(canvas.getContext('2d'), chartData));
}

/* ── Chart.js: Donut Komposisi Data ───────────────────────── */
function initCompositionChart() {
    const canvas = document.getElementById('chartKomposisi');
    const payload = readJsonIsland('dashboard-composition-data');

    if (!canvas || !payload || typeof Chart === 'undefined') return;

    const labels = Array.isArray(payload.labels) ? payload.labels : [];
    const values = Array.isArray(payload.values) ? payload.values.map(Number) : [];
    const colors = Array.isArray(payload.colors) ? payload.colors : ['#2563EB'];
    const total = values.reduce((sum, value) => sum + (Number.isFinite(value) ? value : 0), 0);

    if (!labels.length || total <= 0) return;

    const formatter = new Intl.NumberFormat('id-ID');
    const centerText = {
        id: 'dashCenterText',
        afterDraw(chart) {
            if (chart.config.type !== 'doughnut') return;

            const { ctx } = chart;
            const meta = chart.getDatasetMeta(0);
            if (!meta.data.length) return;

            const { x, y } = meta.data[0];
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#0F172A';
            ctx.font = "700 20px 'Poppins', sans-serif";
            ctx.fillText(formatter.format(total), x, y - 8);
            ctx.fillStyle = '#64748B';
            ctx.font = "500 11px 'Poppins', sans-serif";
            ctx.fillText('Total Data', x, y + 12);
            ctx.restore();
        },
    };

    new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels,
            datasets: [
                {
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 3,
                    borderColor: '#FFFFFF',
                    hoverOffset: 6,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            animation: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        boxWidth: 8,
                        boxHeight: 8,
                        padding: 12,
                        color: '#64748B',
                        font: { family: 'Poppins', size: 10.5, weight: '500' },
                    },
                },
                tooltip: {
                    backgroundColor: '#0F172A',
                    titleColor: '#F8FAFC',
                    bodyColor: '#CBD5E1',
                    cornerRadius: 10,
                    padding: 12,
                    usePointStyle: true,
                    titleFont: { family: 'Poppins', size: 12, weight: '600' },
                    bodyFont: { family: 'Poppins', size: 12 },
                    callbacks: {
                        label(context) {
                            const value = context.parsed ?? 0;
                            const percent = total > 0 ? Math.round((value / total) * 100) : 0;
                            return ` ${context.label}: ${formatter.format(value)} (${percent}%)`;
                        },
                    },
                },
            },
        },
        plugins: [centerText],
    });
}

/* ── Leaflet: Sebaran Data Wilayah ────────────────────────── */
function initMap() {
    const container = document.getElementById('dashboardMap');
    if (!container || typeof L === 'undefined') return;

    const payload = readJsonIsland('dashboard-map-data');
    const markers = Array.isArray(payload?.markers) ? payload.markers : [];

    const map = L.map(container, {
        scrollWheelZoom: false,
        attributionControl: true,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    if (markers.length) {
        const bounds = L.latLngBounds(markers.map((m) => [m.lat, m.lng]));
        map.fitBounds(bounds.pad(0.25), { maxZoom: 11 });
    } else {
        map.setView([-3.35, 125.75], 7);
    }

    const markerStyles = {
        wilayah: { color: '#2563EB', icon: 'bi-geo-alt-fill', label: 'Data wilayah' },
        usaha: { color: '#0891B2', icon: 'bi-briefcase-fill', label: 'Usaha ESDM' },
    };

    markers.forEach((marker) => {
        const kind = marker.type === 'usaha' ? 'usaha' : 'wilayah';
        const style = markerStyles[kind];
        const icon = L.divIcon({
            className: 'dash-marker-wrapper',
            html: `<span class="dash-marker" style="--marker-color: ${style.color}"><span class="dash-marker-pin"><i class="bi ${style.icon}" aria-hidden="true"></i></span></span>`,
            iconSize: [32, 40],
            iconAnchor: [16, 38],
            popupAnchor: [0, -34],
        });

        const title = escapeHtml(marker.title || style.label);
        const description = escapeHtml(marker.description || '');

        L.marker([marker.lat, marker.lng], {
            icon,
            title: `${style.label}: ${marker.title || '-'}`,
            alt: `${style.label}: ${marker.title || '-'}`,
        })
            .addTo(map)
            .bindPopup(`<strong>${title}</strong><br><span class="map-popup-meta">${description}</span>`);
    });

    // Pastikan tile ter-render penuh setelah layout selesai.
    setTimeout(() => map.invalidateSize(), 150);
}

/* ── Bootstrap ────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    try { initChart(); } catch (error) { console.warn('Dashboard: chart gagal.', error); }
    try { initCompositionChart(); } catch (error) { console.warn('Dashboard: donut komposisi gagal.', error); }
    try { initMap(); } catch (error) { console.warn('Dashboard: peta gagal.', error); }
});
