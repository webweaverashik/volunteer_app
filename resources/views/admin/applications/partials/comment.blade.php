<a href="#" data-bs-toggle="modal" data-bs-target="#c{{ $v->id }}">
    <i class="bi bi-eye fs-4"></i>
</a>

<span class="d-none export-comment">{{ $v->comments }}</span>

<div class="modal fade" id="c{{ $v->id }}" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title fs-6">মন্তব্য</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">{{ $v->comments }}</div>
        </div>
    </div>
</div>
