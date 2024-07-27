package org.example;

import com.auth0.jwt.JWT;
import com.auth0.jwt.JWTVerifier;
import com.auth0.jwt.algorithms.Algorithm;
import com.auth0.jwt.interfaces.DecodedJWT;
import junit.framework.Test;
import junit.framework.TestCase;
import junit.framework.TestSuite;

import java.util.Date;
import java.util.HashMap;
import java.util.Map;

/**
 * Unit test for simple App.
 */
public class JwtTest
    extends TestCase
{

    public void testGen(){
        Map<String, Object> claims = new HashMap<>();
        claims.put("id",1);
        claims.put("username","张三");
        String token = JWT.create()
                .withClaim("user",claims)//添加负载
                .withExpiresAt(new Date(System.currentTimeMillis()+1000*60*60*12))//添加过期时间
                .sign(Algorithm.HMAC256("itniuma"));//指定算法
        System.out.println(token);
    }


    public void testParse(){
        //验证
        String token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9" +
                ".eyJ1c2VyIjp7ImlkIjoxLCJ1c2VybmFtZSI6IuW8oOS4iSJ9LCJleHAiOjE3MjEyMzEwOTR9" +
                ".chyz3HLZnfkcIqj-TRvW9hw6w1RTuoi0JPDiyt8BDsI";
        JWTVerifier jWTVerifier =  JWT.require(Algorithm.HMAC256("itniuma")).build();
        DecodedJWT verify = jWTVerifier.verify(token);
        System.out.println(verify.getClaim("user").asMap().get("username"));
    }


}
