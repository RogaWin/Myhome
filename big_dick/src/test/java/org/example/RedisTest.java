package org.example;

import com.itniuma.BigEventApplication;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.data.redis.core.StringRedisTemplate;
import org.springframework.data.redis.core.ValueOperations;

import java.util.concurrent.TimeUnit;

@SpringBootTest(classes = BigEventApplication.class)
public class RedisTest {
    @Autowired(required = false)
    private StringRedisTemplate stringRedisTemplate;

    @Test
    public void testSet() {
        //往redis中存储一个键值对
        ValueOperations<String, String> operations = stringRedisTemplate.opsForValue();
        operations.set("username", "zhangsan");
        operations.set("id","1",15, TimeUnit.SECONDS);
    }
    @Test
    public void testGet(){
        //从redis中获取一个键值对
        ValueOperations<String, String> operations = stringRedisTemplate.opsForValue();
        System.out.println(operations.get("username"));
    }
}
