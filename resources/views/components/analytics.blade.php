<section class="analytics-minimal" id="analytics">
    <div class="analytics-container">
        <div class="analytics-grid reveal">
            <div class="analytics-info">
                <span class="label">Insights</span>
                <h2 class="title">Analyze your <br />entire empire.</h2>
                <p class="desc">
                    From conversion rates to global logistics, get the data 
                    you need to grow your business faster.
                </p>
                
                <div class="stats-list">
                    <div class="stat-item">
                        <span class="stat-num">99.9%</span>
                        <span class="stat-lab">Accuracy</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">24/7</span>
                        <span class="stat-lab">Monitoring</span>
                    </div>
                </div>
            </div>

            <div class="analytics-visual">
                <div class="visual-card">
                    <div class="visual-header">
                        <div class="v-dot red"></div>
                        <div class="v-dot yellow"></div>
                        <div class="v-dot green"></div>
                    </div>
                    <div class="visual-content">
                        <div class="graph">
                            @php $heights = [40, 70, 45, 90, 65, 80, 50]; @endphp
                            @foreach ($heights as $i => $h)
                                <div 
                                    class="bar" 
                                    style="height: {{ $h }}%; animation-delay: {{ $i * 0.1 }}s;"
                                ></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="visual-glow"></div>
            </div>
        </div>
    </div>
</section>
