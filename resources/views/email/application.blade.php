Olá,

@if (!empty($data['application_text']))
{{ $data['application_text'] }}
@else
Meu nome é {{ $data['nome'] }} e tenho interesse na vaga de {{ $data['cargo'] }}@if (!empty($data['empresa'])) na {{ $data['empresa'] }}@endif. Segue meu currículo para análise.
@endif
@if (!empty($data['cover_letter']))

{{ $data['cover_letter'] }}
@endif
@if (!empty($data['pretensao_clt']) || !empty($data['pretensao_pj']))

Pretensão salarial:
@if (!empty($data['pretensao_clt']))
CLT: {{ $data['pretensao_clt'] }}
@endif
@if (!empty($data['pretensao_pj']))
PJ: {{ $data['pretensao_pj'] }}
@endif
@endif
@if (!empty($data['relocation']))

Tenho interesse em realocação para {{ $data['relocation_city'] }}.
@endif
@if (!empty($data['is_fallback_english']))

Obs.: envio meu currículo em inglês, idioma no qual sou proficiente.
@endif

@if (!empty($data['curriculo_url']))Currículo: {{ $data['curriculo_url'] }}
@endif
@if (!empty($data['linkedin']))LinkedIn: {{ $data['linkedin'] }}
@endif
@if (!empty($data['github']))GitHub: {{ $data['github'] }}
@endif

Atenciosamente,
{{ $data['nome'] }}
