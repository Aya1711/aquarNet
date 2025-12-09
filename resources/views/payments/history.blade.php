@extends('layouts.app')

@section('title', __('payment_history'))

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('payment_history') }}</h4>
                </div>
                <div class="card-body">
                    @if($payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('property') }}</th>
                                        <th>{{ __('amount') }}</th>
                                        <th>{{ __('status') }}</th>
                                        <th>{{ __('date') }}</th>
                                        <th>{{ __('actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>
                                                <a href="{{ route('properties.show', $payment->bien->id_bien) }}">
                                                    {{ $payment->bien->titre }}
                                                </a>
                                            </td>
                                            <td>{{ $payment->montant }} {{ __('currency') }}</td>
                                            <td>
                                                @if($payment->statut == 'paye')
                                                    <span class="badge bg-success">{{ __('paid') }}</span>
                                                @elseif($payment->statut == 'en_attente')
                                                    <span class="badge bg-warning">{{ __('pending') }}</span>
                                                @elseif($payment->statut == 'echoue')
                                                    <span class="badge bg-danger">{{ __('failed') }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $payment->statut }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($payment->statut == 'en_attente')
                                                    <a href="{{ route('payment.process', $payment->id_paiement) }}" class="btn btn-sm btn-primary">
                                                        {{ __('complete_payment') }}
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $payments->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <h5>{{ __('no_payments_found') }}</h5>
                            <p class="text-muted">{{ __('no_payments_message') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
