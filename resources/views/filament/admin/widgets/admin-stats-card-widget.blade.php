<x-filament-widgets::widget>
<style>
.adm-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}
@media (max-width: 1024px) {
    .adm-stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .adm-stats-grid { grid-template-columns: 1fr; }
}
.adm-stat-card {
    border-radius: 1rem;
    padding: 1.25rem 1.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: default;
    min-height: 110px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.adm-stat-card:hover {
    transform: translateY(-3px);
}
.adm-stat-card::before {
    content: '';
    position: absolute;
    top: -20%;
    right: -15%;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
}
.adm-stat-card::after {
    content: '';
    position: absolute;
    bottom: -30%;
    right: 5%;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.adm-stat-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}
.adm-stat-icon {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.625rem;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    backdrop-filter: blur(4px);
}
.adm-stat-badge {
    font-size: 0.6rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: rgba(255,255,255,0.22);
    padding: 0.15rem 0.5rem;
    border-radius: 999px;
    backdrop-filter: blur(4px);
}
.adm-stat-bottom {
    position: relative;
    z-index: 1;
    margin-top: 0.75rem;
}
.adm-stat-label {
    font-size: 0.78rem;
    font-weight: 500;
    color: rgba(255,255,255,0.85);
    margin: 0;
}
.adm-stat-value {
    font-size: 1.75rem;
    font-weight: 800;
    margin: 0.15rem 0 0;
    line-height: 1.2;
}
</style>

<div class="adm-stats-grid">
    @foreach($stats as $stat)
    <div class="adm-stat-card"
         style="background: {{ $stat['gradient'] }}; box-shadow: 0 8px 25px -4px {{ $stat['shadow'] }};">
        <div class="adm-stat-top">
            <div class="adm-stat-icon">{{ $stat['icon'] }}</div>
            <span class="adm-stat-badge">{{ $stat['badge'] }}</span>
        </div>
        <div class="adm-stat-bottom">
            <p class="adm-stat-label">{{ $stat['label'] }}</p>
            <p class="adm-stat-value">{{ number_format($stat['value']) }}</p>
        </div>
    </div>
    @endforeach
</div>
</x-filament-widgets::widget>
