@extends('layouts.app')

@section('title', 'Detail Arsip Surat')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Arsip Surat >> Lihat</h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <!-- Header Info -->
                <div class="bg-light p-3 border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td width="25%"><strong>Nomor:</strong></td>
                                    <td>{{ sprintf('%04d/%s/%s/%03d', 
                                        $arsipSurat->id, 
                                        strtoupper(substr($arsipSurat->kategoriSurat->nama_kategori, 0, 3)), 
                                        'TU', 
                                        date('y', strtotime($arsipSurat->tanggal_surat))
                                    ) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori:</strong></td>
                                    <td>{{ $arsipSurat->kategoriSurat->nama_kategori }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Judul:</strong></td>
                                    <td>{{ $arsipSurat->judul_surat }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Waktu Unggah:</strong></td>
                                    <td>{{ $arsipSurat->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- PDF Viewer Area -->
                <div class="p-3">
                    <div class="pdf-viewer-container" style="border: 1px solid #ddd; background-color: #f8f9fa;">
                        <!-- PDF Viewer Controls -->
                        <div class="pdf-controls bg-dark text-white p-2 d-flex justify-content-between align-items-center">
                            <div>
                                <button id="prev-page" class="btn btn-sm btn-outline-light me-2" disabled>
                                    <i class="fas fa-chevron-left"></i> Prev
                                </button>
                                <span id="page-info">Page 1 of 1</span>
                                <button id="next-page" class="btn btn-sm btn-outline-light ms-2" disabled>
                                    Next <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            <div>
                                <button id="zoom-out" class="btn btn-sm btn-outline-light me-1">
                                    <i class="fas fa-search-minus"></i>
                                </button>
                                <span id="zoom-level">100%</span>
                                <button id="zoom-in" class="btn btn-sm btn-outline-light ms-1">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- PDF Canvas Container -->
                        <div class="pdf-canvas-container text-center" style="height: 600px; overflow: auto; background: white;">
                            <canvas id="pdf-canvas" style="display: none;"></canvas>

                            <!-- Loading State -->
                            <div id="pdf-loading" class="d-flex justify-content-center align-items-center h-100">
                                <div class="text-center">
                                    <div class="spinner-border text-primary mb-3" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p>Memuat dokumen PDF...</p>
                                    <small class="text-muted">File: {{ basename($arsipSurat->file_pdf) }}</small>
                                </div>
                            </div>

                            <!-- Error State -->
                            <div id="pdf-error" class="d-none">
                                <div class="alert alert-warning text-center">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <h5>Tidak dapat memuat PDF</h5>
                                    <p>Silakan gunakan tombol "Unduh" untuk membuka file.</p>
                                    <small class="text-muted" id="error-message"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="p-3 bg-light border-top">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('arsip-surat.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                        <div class="btn-group">
                            <a href="{{ route('arsip-surat.download', $arsipSurat) }}"
                                class="btn btn-success">
                                <i class="fas fa-download"></i> Unduh
                            </a>

                            <a href="{{ route('arsip-surat.edit', $arsipSurat) }}"
                                class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit/Ganti File
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    // PDF.js Configuration
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    let pdfDoc = null;
    let pageNum = 1;
    let pageRendering = false;
    let pageNumPending = null;
    let scale = 1.0;
    const canvas = document.getElementById('pdf-canvas');
    const ctx = canvas.getContext('2d');

    // PDF URL dengan error handling
    const pdfUrl = '{{ asset("storage/" . $arsipSurat->file_pdf) }}';
    console.log('PDF URL:', pdfUrl);

    /**
     * Update navigation buttons
     */
    function updateButtons() {
        document.getElementById('prev-page').disabled = (pageNum <= 1);
        document.getElementById('next-page').disabled = (pageNum >= pdfDoc.numPages);
    }

    /**
     * Render page with improved scaling
     */
    function renderPage(num) {
        pageRendering = true;

        pdfDoc.getPage(num).then(function(page) {
            // Get container width
            const container = canvas.parentElement;
            const containerWidth = container.clientWidth - 40; // Padding

            // Calculate scale to fit container
            const viewport = page.getViewport({ scale: 1.0 });
            const autoScale = containerWidth / viewport.width;
            
            // Apply user scale on top of auto scale
            const finalScale = scale * autoScale;
            const scaledViewport = page.getViewport({ scale: finalScale });

            // Set canvas dimensions
            canvas.height = scaledViewport.height;
            canvas.width = scaledViewport.width;

            // Render context
            const renderContext = {
                canvasContext: ctx,
                viewport: scaledViewport
            };

            const renderTask = page.render(renderContext);

            renderTask.promise.then(function() {
                pageRendering = false;
                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        }).catch(function(error) {
            console.error('Error rendering page:', error);
            pageRendering = false;
        });

        // Update page info and buttons
        document.getElementById('page-info').textContent = `Page ${num} of ${pdfDoc.numPages}`;
        updateButtons();
    }

    /**
     * Queue render page
     */
    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    /**
     * Go to previous page
     */
    function onPrevPage() {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    }

    /**
     * Go to next page
     */
    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    }

    /**
     * Zoom in
     */
    function onZoomIn() {
        scale = Math.min(scale + 0.25, 3.0); // Max 300%
        document.getElementById('zoom-level').textContent = Math.round(scale * 100) + '%';
        queueRenderPage(pageNum);
    }

    /**
     * Zoom out
     */
    function onZoomOut() {
        scale = Math.max(scale - 0.25, 0.25); // Min 25%
        document.getElementById('zoom-level').textContent = Math.round(scale * 100) + '%';
        queueRenderPage(pageNum);
    }

    // Event listeners
    document.getElementById('prev-page').addEventListener('click', onPrevPage);
    document.getElementById('next-page').addEventListener('click', onNextPage);
    document.getElementById('zoom-in').addEventListener('click', onZoomIn);
    document.getElementById('zoom-out').addEventListener('click', onZoomOut);

    // Load PDF with better error handling
    pdfjsLib.getDocument({
        url: pdfUrl,
        httpHeaders: {
            'Cache-Control': 'no-cache'
        }
    }).promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        console.log('PDF loaded successfully. Pages:', pdfDoc.numPages);
        
        // Hide loading, show canvas
        document.getElementById('pdf-loading').style.display = 'none';
        document.getElementById('pdf-canvas').style.display = 'block';

        // Render first page
        renderPage(pageNum);
        
    }).catch(function(error) {
        console.error('Error loading PDF:', error);
        
        // Hide loading, show error
        document.getElementById('pdf-loading').style.display = 'none';
        document.getElementById('pdf-error').classList.remove('d-none');
        document.getElementById('error-message').textContent = 'Error: ' + error.message;
    });

    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (pdfDoc) {
                queueRenderPage(pageNum);
            }
        }, 100);
    });
</script>
@endpush