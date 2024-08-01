package com.itniuma.controller;

import com.itniuma.pojo.Result;
import com.itniuma.utils.AliOssUtil;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.util.UUID;

@RestController
public class FileController {

    @PostMapping(value = "/upload")
    public Result upload(MultipartFile file) throws Exception {
        // 上传逻辑
        String originalFilename = file.getOriginalFilename();
        //保证文件的名字是唯一的
        String fileName = UUID.randomUUID().toString()+originalFilename.substring(originalFilename.lastIndexOf("."));
        //file.transferTo(new File("A:\\桌面\\files\\"+fileName));
        String url = AliOssUtil.uploadFile(fileName,file.getInputStream());
        return Result.success(url);
    }

    @PostMapping(value = "/deleteFile")
    public Result deleteFile(@RequestBody String url) throws Exception {
        AliOssUtil.deleteFile(url);
        return Result.success();
    }
}
