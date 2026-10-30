const locationPermissionButtons = document.querySelectorAll('[data-request-location]');

locationPermissionButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const message = document.querySelector('[data-location-message]');

        if (!navigator.geolocation) {
            if (message) {
                message.hidden = false;
                message.textContent = 'Browser ini belum mendukung akses lokasi. Buka dengan browser terbaru dan coba lagi.';
            }

            return;
        }

        button.disabled = true;
        button.textContent = 'Memeriksa lokasi…';

        navigator.geolocation.getCurrentPosition(
            () => window.location.assign(document.body.dataset.mapUrl),
            (error) => {
                button.disabled = false;
                button.textContent = button.dataset.retryLabel || 'Coba lagi';

                if (error.code === error.PERMISSION_DENIED) {
                    window.location.assign(document.body.dataset.locationDeniedUrl);
                    return;
                }

                if (message) {
                    message.hidden = false;
                    message.textContent = 'Lokasi belum dapat diperiksa. Pastikan GPS aktif, lalu coba lagi.';
                }
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 },
        );
    });
});

const reportFilters = {
    category: 'all',
    status: 'all',
    radius: '1 km',
};

const reportCards = [...document.querySelectorAll('[data-report-card]')];
const mapMarkers = [...document.querySelectorAll('[data-map-marker]')];

function applyReportFilters() {
    const radiusMeters = Number.parseInt(reportFilters.radius, 10) * (reportFilters.radius.includes('km') ? 1000 : 1);
    let visibleCount = 0;

    reportCards.forEach((card) => {
        const matchesCategory = reportFilters.category === 'all' || card.dataset.category === reportFilters.category;
        const matchesStatus = reportFilters.status === 'all' || card.dataset.status === reportFilters.status;
        const matchesRadius = Number(card.dataset.distance || 0) * 1000 <= radiusMeters;
        const isVisible = matchesCategory && matchesStatus && matchesRadius;
        card.hidden = !isVisible;

        if (isVisible) {
            visibleCount += 1;
        }
    });

    mapMarkers.forEach((marker) => {
        const matchesCategory = reportFilters.category === 'all' || marker.dataset.category === reportFilters.category;
        const matchesStatus = reportFilters.status === 'all' || marker.dataset.status === reportFilters.status;
        const matchesRadius = Number(marker.dataset.distance || 0) * 1000 <= radiusMeters;
        marker.hidden = !(matchesCategory && matchesStatus && matchesRadius);
    });

    const count = document.querySelector('[data-report-count]');

    if (count) {
        count.textContent = String(visibleCount);
    }

    const radiusText = document.querySelector('[data-radius-label]');

    if (radiusText) {
        radiusText.textContent = reportFilters.radius;
    }
}

document.querySelectorAll('[data-filter-category]').forEach((button) => {
    button.addEventListener('click', () => {
        reportFilters.category = button.dataset.filterCategory;
        document.querySelectorAll('[data-filter-category]').forEach((chip) => chip.setAttribute('aria-pressed', String(chip === button)));
        applyReportFilters();
    });
});

document.querySelectorAll('[data-filter-status]').forEach((button) => {
    button.addEventListener('click', () => {
        reportFilters.status = button.dataset.filterStatus;
        document.querySelectorAll('[data-filter-status]').forEach((chip) => chip.setAttribute('aria-pressed', String(chip === button)));
        applyReportFilters();
    });
});

document.querySelector('[data-radius-filter]')?.addEventListener('change', (event) => {
    reportFilters.radius = event.currentTarget.value;
    applyReportFilters();
});

if (document.querySelector('[data-map-geolocation-gate]')) {
    if (!navigator.geolocation) {
        window.location.replace('/lokasi-belum-aktif');
    } else {
        navigator.geolocation.getCurrentPosition(
            () => {},
            () => window.location.replace(document.body.dataset.locationDeniedUrl),
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 },
        );
    }
}

mapMarkers.forEach((marker) => {
    marker.addEventListener('click', () => {
        mapMarkers.forEach((item) => item.setAttribute('aria-pressed', String(item === marker)));

        const popup = document.querySelector('[data-map-popup]');
        const selectedCard = document.querySelector(`[data-report-card][data-ticket="${CSS.escape(marker.dataset.ticket)}"]`);

        reportCards.forEach((card) => card.classList.toggle('is-selected', card === selectedCard));

        if (!popup) {
            return;
        }

        popup.replaceChildren();
        popup.classList.add('is-open');
        const image = marker.dataset.image;

        if (image) {
            const photo = document.createElement('img');
            photo.src = image;
            photo.alt = `Foto laporan ${marker.dataset.categoryLabel}`;
            photo.loading = 'lazy';
            popup.append(photo);
        }

        const heading = document.createElement('h2');
        heading.textContent = marker.dataset.title;
        const category = document.createElement('p');
        category.textContent = `${marker.dataset.categoryLabel} · ${marker.dataset.status}`;
        const address = document.createElement('p');
        address.textContent = marker.dataset.location;
        const detail = document.createElement('a');
                detail.href = marker.dataset.detailUrl;
        detail.textContent = 'Lihat detail laporan →';
        popup.append(heading, category, address, detail);
    });
});

document.querySelectorAll('[data-map-zoom]').forEach((button) => {
    button.addEventListener('click', () => {
        const map = document.querySelector('[data-civic-map] svg');

        if (!map) {
            return;
        }

        const currentZoom = Number(map.dataset.zoom || 1);
        const nextZoom = button.dataset.mapZoom === 'in' ? Math.min(currentZoom + 0.12, 1.6) : Math.max(currentZoom - 0.12, 0.8);
        map.dataset.zoom = String(nextZoom);
        map.style.transform = `scale(${nextZoom})`;
        map.style.transition = 'transform 180ms ease-out';
    });
});

document.querySelector('[data-map-center]')?.addEventListener('click', () => {
    document.querySelector('[data-civic-map]')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
});

const photoInput = document.querySelector('[data-photo-input]');
const photoPreviews = document.querySelector('[data-photo-previews]');
const submitReport = document.querySelector('[data-submit-report]');
const latitudeField = document.querySelector('[data-latitude]');
const longitudeField = document.querySelector('[data-longitude]');
const gpsState = document.querySelector('[data-gps-state]');

function updateReportSubmitState() {
    const hasLocation = latitudeField?.value && longitudeField?.value;
    const hasPhoto = photoInput?.files?.length > 0 && photoInput.files.length <= 5;

    if (submitReport) {
        submitReport.disabled = !(hasLocation && hasPhoto);
    }
}

if (latitudeField && longitudeField && gpsState) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            ({ coords }) => {
                latitudeField.value = coords.latitude.toFixed(6);
                longitudeField.value = coords.longitude.toFixed(6);
                gpsState.textContent = 'Titik GPS berhasil diambil. Lokasi perangkat tidak disimpan sebagai data pencarian.';
                gpsState.classList.remove('field-error');
                updateReportSubmitState();
            },
            () => {
                gpsState.textContent = 'Izin lokasi diperlukan untuk mengirim laporan.';
                const locationHelp = document.querySelector('[data-location-help]');
                if (locationHelp) {
                    locationHelp.hidden = false;
                }
                gpsState.classList.add('field-error');
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 },
        );
    } else {
        gpsState.textContent = 'Browser ini belum mendukung akses lokasi.';
        gpsState.classList.add('field-error');
    }
}

photoInput?.addEventListener('change', () => {
    if (photoPreviews) {
        photoPreviews.replaceChildren();

        [...photoInput.files].slice(0, 5).forEach((file) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'upload-preview';
            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.alt = `Pratinjau ${file.name}`;
            wrapper.append(image);
            photoPreviews.append(wrapper);
        });
    }

    const help = photoInput.closest('section')?.querySelector('.form-help');

    if (help && photoInput.files.length > 5) {
        help.textContent = 'Pilih maksimal 5 foto.';
        help.classList.add('field-error');
    }

    updateReportSubmitState();
});

const descriptionField = document.querySelector('#report-description');
const characterCount = document.querySelector('[data-character-count]');

descriptionField?.addEventListener('input', () => {
    if (characterCount) {
        characterCount.textContent = `${descriptionField.value.length} / 500`;
    }
});

document.querySelector('[data-print-ticket]')?.addEventListener('click', () => window.print());

document.querySelectorAll('[data-copy]').forEach((button) => {
    button.addEventListener('click', async () => {
        const value = button.dataset.copy;

        try {
            await navigator.clipboard.writeText(value);
        } catch {
            const temporaryInput = document.createElement('textarea');
            temporaryInput.value = value;
            temporaryInput.style.position = 'fixed';
            temporaryInput.style.opacity = '0';
            document.body.append(temporaryInput);
            temporaryInput.select();
            document.execCommand('copy');
            temporaryInput.remove();
        }

        const label = button.querySelector('[data-copy-label]');
        if (label) {
            label.textContent = 'Tersalin';
        }
        button.setAttribute('aria-label', 'ID tiket berhasil disalin');
        window.setTimeout(() => {
            if (label) {
                label.textContent = 'Salin ID';
            }
        }, 1800);
    });
});

document.querySelector('[data-staff-filter]')?.addEventListener('change', (event) => {
    const selectedStatus = event.currentTarget.value;
    document.querySelectorAll('[data-staff-row]').forEach((row) => {
        row.hidden = selectedStatus !== 'all' && row.dataset.status !== selectedStatus;
    });
});

applyReportFilters();
