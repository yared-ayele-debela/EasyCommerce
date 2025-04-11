<div class="mb-3">
    <input type="hidden" name="admin_id" value="{{ Auth::guard('admin')->user()->id }}">
    <label class="form-label">Coupon Code</label>
    <input type="text" name="code" class="form-control" value="{{ old('code', $coupon->code ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Type</label>
    <select name="type" class="form-select" required>
        <option value="fixed" @if(old('type', $coupon->type ?? '') == 'fixed') selected @endif>Fixed</option>
        <option value="percent" @if(old('type', $coupon->type ?? '') == 'percent') selected @endif>Percent</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Value</label>
    <input type="number" name="value" class="form-control" step="0.01" value="{{ old('value', $coupon->value ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Usage Limit</label>
    <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Expires At</label>
    <input type="date" name="expires_at" class="form-control" value="{{ old('expires_at', $coupon->expires_at ?? '') }}">
</div>
