import{y as n,w as t,o as l,b as a,u as r,d as e,g as d,n as p,f}from"./app-B5YizUfN.js";import{_ as u}from"./Button-BW3n6imP.js";import{_ as c}from"./Guest-D4TULzrj.js";import{_}from"./Input-nHk-go8h.js";import{_ as w}from"./Label-DprXL7X-.js";import{_ as b}from"./ValidationErrors-DSzeQEbw.js";import{a as x,H as y}from"./index-CW21pWhN.js";/* empty css            */import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./index-BCCQOF59.js";const V={class:"flex justify-end mt-4"},j={__name:"ConfirmPassword",setup(g){const s=x({password:""}),i=()=>{s.post(route("password.confirm"),{onFinish:()=>s.reset()})};return(v,o)=>(l(),n(c,null,{default:t(()=>[a(r(y),{title:"Confirm Password"}),o[2]||(o[2]=e("div",{class:"mb-4 text-sm text-gray-600"}," This is a secure area of the application. Please confirm your password before continuing. ",-1)),a(b,{class:"mb-4"}),e("form",{onSubmit:f(i,["prevent"])},[e("div",null,[a(w,{for:"password",value:"Password"}),a(_,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:r(s).password,"onUpdate:modelValue":o[0]||(o[0]=m=>r(s).password=m),required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"])]),e("div",V,[a(u,{class:p(["ml-4",{"opacity-25":r(s).processing}]),disabled:r(s).processing},{default:t(()=>o[1]||(o[1]=[d(" Confirm ")])),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{j as default};
