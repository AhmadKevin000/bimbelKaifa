<x-filament-widgets::widget>
<style>
.tour-card {
    border-radius: 1rem;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
    background: #ffffff;
}
.dark .tour-card {
    background: #1e293b;
    border-color: rgba(255,255,255,0.06);
}
.tour-card-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    padding: 1.5rem 2rem;
}
@media (max-width: 640px) {
    .tour-card-inner { flex-direction: column; align-items: flex-start; }
}
.tour-card-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    min-width: 0;
}
.tour-card-icon {
    width: 3rem;
    height: 3rem;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
    box-shadow: 0 4px 12px rgba(6, 182, 212, 0.35);
    flex-shrink: 0;
}
.tour-card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.dark .tour-card-title { color: #f1f5f9; }
.tour-card-desc {
    font-size: 0.82rem;
    color: #64748b;
    margin: 0.2rem 0 0;
    line-height: 1.4;
}
.dark .tour-card-desc { color: #94a3b8; }
.tour-card-right {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-shrink: 0;
}
.tour-btn-start {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    border-radius: 0.625rem;
    background: linear-gradient(135deg, #4364F7 0%, #6FB1FC 100%);
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(67, 100, 247, 0.3);
    transition: all 0.2s ease;
    text-decoration: none;
}
.tour-btn-start:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(67, 100, 247, 0.4);
}
.tour-footer {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 0.75rem 2rem;
    border-top: 1px solid #f1f5f9;
    background: #f8fafc;
}
.dark .tour-footer {
    border-top-color: #334155;
    background: #1a2332;
}
.tour-footer-link {
    font-size: 0.78rem;
    color: #4364F7;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    transition: opacity 0.15s;
}
.tour-footer-link:hover { opacity: 0.7; }
.dark .tour-footer-link { color: #6FB1FC; }
.tour-footer-sep {
    width: 1px;
    height: 1rem;
    background: #e2e8f0;
}
.dark .tour-footer-sep { background: #475569; }
</style>

<div class="tour-card">
    <div class="tour-card-inner">
        <div class="tour-card-left">
            <div class="tour-card-icon">
                <x-heroicon-o-rocket-launch style="width: 1.5rem; height: 1.5rem; color: #ffffff; flex-shrink: 0;" />
            </div>
            <div>
                <h3 class="tour-card-title">Panduan Sistem</h3>
                <p class="tour-card-desc">Pelajari alur penggunaan sistem bimbel mulai dari pengelolaan data master hingga proses absensi dan keuangan.</p>
            </div>
        </div>
        <div class="tour-card-right">
            <button type="button" class="tour-btn-start" onclick="startSystemTour()">
                <x-heroicon-m-play style="width: 1rem; height: 1rem; margin-right: 0.25rem; flex-shrink: 0;" /> Mulai Panduan
            </button>
        </div>
    </div>
</div>
</x-filament-widgets::widget>
