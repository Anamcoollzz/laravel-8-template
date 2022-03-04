<?php

/**
 * successMessageCreate
 *
 * @param string $nextTitle
 * @return string
 */
function successMessageCreate($nextTitle = '')
{
    return __('Berhasil Menambahkan Data ' . ucwords($nextTitle));
}

/**
 * successMessageUpdate
 *
 * @param string $nextTitle
 * @return string
 */
function successMessageUpdate($nextTitle = '')
{
    return __('Berhasil Memperbarui Data ' . ucwords($nextTitle));
}

/**
 * successMessageDelete
 *
 * @param string $nextTitle
 * @return string
 */
function successMessageDelete($nextTitle = '')
{
    return __('Berhasil Menghapus Data ' . ucwords($nextTitle));
}


/**
 * successMessageLoadData
 *
 * @param string $nextTitle
 * @return string
 */
function successMessageLoadData($nextTitle = '')
{
    return __('Berhasil Mengambil Data ' . ucwords($nextTitle));
}


// GAGAL SECCTION
// ===================================================================================================================

/**
 * failedMessageCreate
 *
 * @param string $nextTitle
 * @return string
 */
function failedMessageCreate($nextTitle = '')
{
    return __('Gagal Menambahkan Data ' . ucwords($nextTitle));
}

/**
 * failedMessageUpdate
 *
 * @param string $nextTitle
 * @return string
 */
function failedMessageUpdate($nextTitle = '')
{
    return __('Gagal Memperbarui Data ' . ucwords($nextTitle));
}

/**
 * failedMessageDelete
 *
 * @param string $nextTitle
 * @return string
 */
function failedMessageDelete($nextTitle = '')
{
    return __('Gagal Menghapus Data ' . ucwords($nextTitle));
}


/**
 * failedMessageLoadData
 *
 * @param string $nextTitle
 * @return string
 */
function failedMessageLoadData($nextTitle = '')
{
    return __('Gagal Mengambil Data ' . ucwords($nextTitle));
}
