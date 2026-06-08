<x-filament-widgets::widget>
<style>
.adm-greeting-card {
    background: linear-gradient(135deg, #4364F7 0%, #6FB1FC 100%);
    border-radius: 1rem;
    padding: 1.5rem 2rem;
    color: #fff;
    box-shadow: 0 8px 30px -4px rgba(67, 100, 247, 0.3);
    position: relative;
    overflow: hidden;
}
.adm-greeting-card::before {
    content: '';
    position: absolute;
    top: -30%;
    right: -10%;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
}
.adm-greeting-card::after {
    content: '';
    position: absolute;
    bottom: -40%;
    right: 10%;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.adm-greeting-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    position: relative;
    z-index: 1;
}
.adm-greeting-left {
    flex: 1;
    min-width: 0;
}
.adm-greeting-sub {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.85);
    margin: 0 0 0.25rem;
}
.adm-greeting-name {
    font-size: 1.5rem;
    font-weight: 800;
    color: #ffffff !important;
    margin: 0;
    line-height: 1.3;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.adm-greeting-desc {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.75);
    margin: 0.5rem 0 0;
}
.adm-greeting-right {
    text-align: right;
    flex-shrink: 0;
}
.adm-greeting-date {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.9);
    background: rgba(255,255,255,0.15);
    border-radius: 0.5rem;
    padding: 0.4rem 0.75rem;
    backdrop-filter: blur(4px);
}
</style>

<div class="adm-greeting-card">
    <div class="adm-greeting-inner">
        <div class="adm-greeting-left">
            <p class="adm-greeting-sub">{{ $greeting }},</p>
            <h2 class="adm-greeting-name">{{ $userName }} 👋</h2>
            <p class="adm-greeting-desc">Aktivitas hari ini.</p>
        </div>
        <div class="adm-greeting-right">
            <div class="adm-greeting-date">
                📅 {{ $tanggal }}
            </div>
        </div>
    </div>
</div>
</x-filament-widgets::widget>
