@extends("Layout.main")
@section("title","Evacuation Map")

@section("content")
<div class="container mt-4">
    <div class="header mb-3">
        <h1 class="fw-bold">EVACUATION MAP</h1>
    </div>

    <div class="card shadow-sm rounded-3">
        <div class="card-body">

            {{-- ======= TABS ======= --}}
            <ul class="nav nav-tabs mb-3" id="evacuationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="map-tab" data-bs-toggle="tab" data-bs-target="#mapTab" type="button" role="tab">
                        <i class="bi bi-geo-alt-fill me-1"></i> Map & Add Location
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="locations-tab" data-bs-toggle="tab" data-bs-target="#locationsTab" type="button" role="tab">
                        <i class="bi bi-list-ul me-1"></i> Saved Locations
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="evacuationTabsContent">

                {{-- ======= MAP TAB ======= --}}
                <div class="tab-pane fade show active" id="mapTab" role="tabpanel" aria-labelledby="map-tab">
                    
                    {{-- Success/Error Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- MAP AND FORM --}}
                    <div class="row g-3">
                        {{-- Map --}}
                        <div class="col-lg-7">
                            <div id="map" style="height: 450px; border-radius: 10px; z-index: 0;"></div>
                        </div>

                        {{-- Form --}}
                        <div class="col-lg-5">
                            <div class="border rounded p-3 bg-light shadow-sm">
                                <h5 class="fw-bold mb-3">Add Location</h5>
                                <p class="small text-muted mb-2">
                                    Click on the map to select a location. Coordinates and address will appear below.
                                </p>

                                <div class="mb-2"><b>Latitude:</b> <span id="lat">-</span></div>
                                <div class="mb-2"><b>Longitude:</b> <span id="lng">-</span></div>
                                <div class="mb-3"><b>Address:</b> <span id="addr" class="text-muted">Click a point on the map</span></div>

                                <form id="addLocationForm" action="{{ route('evacuation.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="form-label">Type</label>
                                        <select name="type" class="form-select form-select-sm" required>
                                            <option value="">Select Type</option>
                                            <option value="evacuation">Evacuation Area</option>
                                            <option value="flood">Flood-Prone Area</option>
                                        </select>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Name</label>
                                        <input name="name" class="form-control form-control-sm" placeholder="Name" required>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control form-control-sm" placeholder="Description"></textarea>
                                    </div>

                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                    <input type="hidden" name="address" id="address">

                                    <button type="submit" class="btn btn-primary w-100 mt-2">
                                        <i class="bi bi-save me-1"></i> Save Location
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ======= LOCATIONS TAB ======= --}}
                <div class="tab-pane fade" id="locationsTab" role="tabpanel" aria-labelledby="locations-tab">
                    <div class="mt-3">
                        <h5 class="fw-bold mb-3">Saved Locations</h5>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Address</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($locations as $location)
                                    <tr>
                                        <td>{{ $location->id }}</td>
                                        <td>
                                            <span class="badge {{ $location->type == 'evacuation' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($location->type) }}
                                            </span>
                                        </td>
                                        <td><strong>{{ $location->name }}</strong></td>
                                        <td>{{ $location->description ?: '-' }}</td>
                                        <td style="max-width: 250px; word-wrap: break-word;">{{ $location->address ?: '-' }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-outline-info btn-sm view-location"
                                                data-lat="{{ $location->latitude }}"
                                                data-lng="{{ $location->longitude }}"
                                                data-name="{{ $location->name }}">
                                                <i class="bi bi-geo-alt"></i> View
                                            </button>
                                            <form action="{{ route('evacuation.destroy', $location->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this location?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted fst-italic">No locations found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ======= Leaflet Dependencies ======= --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    if (typeof L === 'undefined') {
        alert('Error loading map library. Please check your internet connection.');
        return;
    }

    const map = L.map('map').setView([6.4974, 124.8463], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Show existing locations
    @foreach($locations as $location)
        L.circleMarker([{{ $location->latitude }}, {{ $location->longitude }}], {
            radius: 8,
            color: "{{ $location->type === 'evacuation' ? 'green' : 'red' }}",
            fillColor: "{{ $location->type === 'evacuation' ? 'green' : 'red' }}",
            fillOpacity: 0.8
        })
        .addTo(map)
        .bindPopup(`<b>{{ $location->name }}</b><br>{{ $location->address ?: '' }}<br><i>{{ $location->type }}</i>`);
    @endforeach

    // Handle clicks for new locations
    let clickMarker = null;
    map.on("click", function (e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);

        document.getElementById("lat").textContent = lat;
        document.getElementById("lng").textContent = lng;
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
        document.getElementById("addr").textContent = "Fetching address...";

        if (clickMarker) map.removeLayer(clickMarker);

        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                const address = data.display_name || "Unknown address";
                document.getElementById("addr").textContent = address;
                document.getElementById("address").value = address;

                clickMarker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(`<b>Selected Location</b><br>${address}`)
                    .openPopup();
            })
            .catch(() => {
                document.getElementById("addr").textContent = "Unable to fetch address.";
            });
    });

    // View existing location button
    document.querySelectorAll('.view-location').forEach(button => {
        button.addEventListener('click', function () {
            const lat = parseFloat(this.dataset.lat);
            const lng = parseFloat(this.dataset.lng);
            const name = this.dataset.name;
            map.setView([lat, lng], 15);
            L.circleMarker([lat, lng], { radius: 12, color: 'blue', fillColor: 'blue', fillOpacity: 0.6 })
                .addTo(map)
                .bindPopup(`<b>${name}</b>`)
                .openPopup();
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
