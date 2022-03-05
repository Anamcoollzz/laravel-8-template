<?php

/**
 * successMessageCreate
 *
 * @param string $nextTitle
 * @return string
 */
function successMessageCreate($nextTitle = '')
{
    return __('Berhasil Menambahkan Data ' . ($nextTitle));
}

/**
 * successMessageUpdate
 *
 * @param string $nextTitle
 * @return string
 */
function successMessageUpdate($nextTitle = '')
{
    return __('Berhasil Memperbarui Data ' . ($nextTitle));
}

/**
 * successMessageDelete
 *
 * @param string $nextTitle
 * @return string
 */
function successMessageDelete($nextTitle = '')
{
    return __('Berhasil Menghapus Data ' . ($nextTitle));
}

/**
 * successMessageImportExcel
 *
 * @param string $nextTitle
 * @return string
 */
function successMessageImportExcel($nextTitle = '')
{
    return __('Berhasil Mengimpor Data ' . ($nextTitle) . ' Dari Excel');
}


/**
 * successMessageLoadData
 *
 * @param string $nextTitle
 * @return string
 */
function successMessageLoadData($nextTitle = '')
{
    return __('Berhasil Mengambil Data ' . ($nextTitle));
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
    return __('Gagal Menambahkan Data ' . ($nextTitle));
}

/**
 * failedMessageUpdate
 *
 * @param string $nextTitle
 * @return string
 */
function failedMessageUpdate($nextTitle = '')
{
    return __('Gagal Memperbarui Data ' . ($nextTitle));
}

/**
 * failedMessageDelete
 *
 * @param string $nextTitle
 * @return string
 */
function failedMessageDelete($nextTitle = '')
{
    return __('Gagal Menghapus Data ' . ($nextTitle));
}


/**
 * failedMessageLoadData
 *
 * @param string $nextTitle
 * @return string
 */
function failedMessageLoadData($nextTitle = '')
{
    return __('Gagal Mengambil Data ' . ($nextTitle));
}
