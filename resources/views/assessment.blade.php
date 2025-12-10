<x-layout>
    <div class="card" style="max-width:760px; margin:24px auto; padding:18px 20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
            <h2 style="margin:0;">Welcome! Let's personalize your plan</h2>
            <span class="badge" style="background:#2e7d32; color:#fff; padding:4px 10px; border-radius:999px;">Step 1 of 1</span>
        </div>
        <p class="text" style="color:#666; margin:8px 0 0;">Answer a few questions so NutriTrack can tailor recommendations for you.</p>

        <form method="POST" action="{{ route('assessment.submit') }}" style="display:grid; gap:18px; margin-top:14px;">
            @csrf
            <div class="form-grid" style="display:grid; grid-template-columns:1fr; gap:14px;">
                <div>
                    <label class="form-label" for="birth_date">Birth Date</label>
                    <input id="birth_date" type="date" name="birth_date" class="form-control" required style="margin-top:6px;" />
                    <small class="text" style="color:#666; display:block; margin-top:6px;">Age preview: <span id="age_preview">—</span></small>
                    @error('birth_date')<p class="text" style="color:#b71c1c;">{{ $message }}</p>@enderror
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:12px;">
                    <div>
                        <label class="form-label" for="height">Height (cm)</label>
                        <input id="height" type="number" step="0.1" name="height" min="0" class="form-control" placeholder="e.g., 170" required style="margin-top:6px;" />
                    </div>
                    <div>
                        <label class="form-label" for="weight">Weight (kg)</label>
                        <input id="weight" type="number" step="0.1" name="weight" min="0" class="form-control" placeholder="e.g., 65" required style="margin-top:6px;" />
                    </div>
                </div>
            </div>

            <!-- Live BMI preview + legend -->
            <div style="background:#f9f9f9; border:1px solid #f1f1f1; border-radius:10px; padding:14px; display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:14px; align-items:center;">
                <div>
                    <div style="display:flex; align-items:baseline; gap:8px;">
                        <span style="font-size:2rem; font-weight:700; color:#2a2a2a;" id="bmi_val">—</span>
                        <small class="text" style="color:#666;">BMI</small>
                    </div>
                    <span id="bmi_status" class="badge" style="display:inline-block; margin-top:8px; background:#9e9e9e; color:#fff; padding:6px 12px; border-radius:999px; font-size:.85rem;">No Status</span>
                </div>
                <div>
                    <div style="position:relative; height:12px; border-radius:8px; overflow:hidden; background: linear-gradient(to right,
                        #f57c00 0% 10%,
                        #2e7d32 10% 37%,
                        #f9a825 37% 58%,
                        #c62828 58% 100%);"></div>
                    <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:10px; font-size:.85rem; color:#555;">
                        <span style="display:inline-flex; align-items:center; gap:6px;"><span style="width:10px;height:10px;background:#f57c00;border-radius:2px;display:inline-block;"></span>Underweight (&lt; 18.5)</span>
                        <span style="display:inline-flex; align-items:center; gap:6px;"><span style="width:10px;height:10px;background:#2e7d32;border-radius:2px;display:inline-block;"></span>Normal (18.5–24.9)</span>
                        <span style="display:inline-flex; align-items:center; gap:6px;"><span style="width:10px;height:10px;background:#f9a825;border-radius:2px;display:inline-block;"></span>Overweight (25–29.9)</span>
                        <span style="display:inline-flex; align-items:center; gap:6px;"><span style="width:10px;height:10px;background:#c62828;border-radius:2px;display:inline-block;"></span>Obese (≥ 30)</span>
                    </div>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:12px;">
                <div>
                    <label class="form-label" for="activity_level">Activity Level (optional)</label>
                    <select id="activity_level" name="activity_level" class="form-control" style="margin-top:6px;">
                        <option value="">Select...</option>
                        <option value="sedentary">Sedentary</option>
                        <option value="light">Lightly active</option>
                        <option value="moderate">Moderately active</option>
                        <option value="active">Active</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="preferences">Food Preferences (optional)</label>
                    <textarea id="preferences" name="preferences" class="form-control" rows="3" placeholder="e.g., likes chicken, avoids dairy" style="margin-top:6px;"></textarea>
                </div>
            </div>

            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:4px;">
                <button type="submit" class="btn-card">Finish</button>
            </div>
        </form>
    </div>

    <script>
        function computeAge(isoDate){
            if(!isoDate) return '';
            var dob = new Date(isoDate);
            if(isNaN(dob.getTime())) return '';
            var now = new Date();
            var diffMs = now - dob;
            var years = diffMs / (1000 * 60 * 60 * 24 * 365.2425);
            return Math.floor(years);
        }
        function computeBMI(heightCm, weightKg){
            var h = parseFloat(heightCm), w = parseFloat(weightKg);
            if(!(h>0) || !(w>0)) return null;
            var m = h/100; return Math.round((w/(m*m))*10)/10;
        }
        function bmiStatus(bmi){
            if(bmi===null || isNaN(bmi)) return {label:'No Status', color:'#9e9e9e'};
            if(bmi < 18.5) return {label:'Underweight', color:'#f57c00'};
            if(bmi < 25) return {label:'Normal', color:'#2e7d32'};
            if(bmi < 30) return {label:'Overweight', color:'#f9a825'};
            return {label:'Obese', color:'#c62828'};
        }
        document.addEventListener('DOMContentLoaded', function(){
            var bd = document.getElementById('birth_date');
            var age = document.getElementById('age_preview');
            var h = document.getElementById('height');
            var w = document.getElementById('weight');
            var bmiVal = document.getElementById('bmi_val');
            var bmiBadge = document.getElementById('bmi_status');

            function updateAge(){ age.textContent = computeAge(bd.value) || '—'; }
            function updateBMI(){
                var bmi = computeBMI(h.value, w.value);
                bmiVal.textContent = (bmi===null)? '—' : bmi;
                var st = bmiStatus(bmi);
                bmiBadge.textContent = st.label;
                bmiBadge.style.background = st.color;
            }
            if(bd && age){ bd.addEventListener('input', updateAge); updateAge(); }
            if(h && w){ h.addEventListener('input', updateBMI); w.addEventListener('input', updateBMI); updateBMI(); }
        });
    </script>
</x-layout>
